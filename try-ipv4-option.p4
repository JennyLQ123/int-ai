header_type ethernet_t {
    fields{
        dstAddr:48;
        srcAddr:48;
        etherType:16;
    }
}

header ethernet_t ethernet;

header_type mri_t {
    fields{
        swid1:8;
        qdepth1:32;
        timestamp1:32;
        swid2:8;
        qdepth2:32;
        timestamp2:32;
        swid3:8;
        qdepth3:32;
        timestamp3:32;
        swid4:8;
        qdepth4:32;
        timestamp4:32;
        swid5:8;
        qdepth5:32;
        timestamp5:32;
    }
}

header mri_t mri;

header_type ipv4_t {
    fields{
        version:4;
        ihl:4;
        diffserv:8;
        totalLen:16;
        identification:16;
        flags:3;
        flagOffset:13;
        ttl:8;
        protocol:8;
        hdrChecksum:16;
        srcAddr:32;
        dstAddr:32;
    }
}

header_type ipv4_option_t{
    fields{
        option:8;
        count:8;
        routeid:16;
    }
}

header ipv4_t ipv4;
header ipv4_option_t ipv4_option;

header_type custom_metadata_t{
    fields{
        dstAddr:32;
    }
}

metadata custom_metadata_t meta;

header_type intrinsic_metadata_t{
    fields{
        ingress_global_timestamp:48;
        lf_field_list:8;
        mcast_grp:16;
        egress_rid:16;
        resubmit_flag:8;
        recirculate_flag:8;
    }
}

metadata intrinsic_metadata_t intrinsic_metadata;

header_type queueing_metadata_t{
    fields{
        enq_timestamp:48;
        enq_qdepth:16;
        deq_timedelta:32;
        deq_qdepth:16;
        qid:8;
    }
}

metadata queueing_metadata_t queueing_metadata;

parser start{
    return parse_ethernet;
}

#define IPV4 0x0800

parser parse_ethernet{
    extract(ethernet);
    return select(latest.etherType){
        IPV4:no_mri;
        default:parse_mri;
    }
}

parser no_mri{
    return parse_ipv4;
}

parser parse_mri{
    extract(mri);
    return parse_ipv4;
}

parser parse_ipv4{
    extract(ipv4);
    return select(ipv4.ihl){
        0x05:ingress;
        default:parse_ipv4_option;
    }
}

parser parse_ipv4_option{
    extract(ipv4_option);
    return ingress;
}

field_list ipv4_checksum_list {
        ipv4.version;
        ipv4.ihl;
        ipv4.diffserv;
        ipv4.totalLen;
        ipv4.identification;
        ipv4.flags;
        ipv4.flagOffset;
        ipv4.ttl;
        ipv4.protocol;
        ipv4.srcAddr;
        ipv4.dstAddr;
        ipv4_option;
}

field_list_calculation ipv4_checksum {
    input {
        ipv4_checksum_list;
    }
    algorithm : csum16;
    output_width : 16;
}

calculated_field ipv4.hdrChecksum  {
    verify ipv4_checksum;
    update ipv4_checksum;
}

action set_routeid(routeid){
    modify_field(ipv4_option.routeid,routeid);
    modify_field(ipv4_option.option,1);
}

table add_routeid{
    reads{
        ipv4.dstAddr:lpm;
    }
    action_profile:set_routeid_profile;
    size:100;
}

action_profile set_routeid_profile{
    actions{
        set_routeid;
    }
    size:5;
    dynamic_action_selection:routeid_selector;
}

field_list routeid_hash_fields{
    ipv4.srcAddr;
    ipv4.dstAddr;
    ipv4.protocol;
}

field_list_calculation routeid_hash{
    input{
        routeid_hash_fields;
    }
    algorithm:crc16;
    output_width:16;
}

action_selector routeid_selector{
    selection_key:routeid_hash;
}

table routeid_fwd{
    reads{
        ipv4_option.routeid:exact;
    }
    actions{
        ipv4_fwd;
        fwd2host;
    }
}

action ipv4_fwd(port){
    modify_field(standard_metadata.egress_spec,port);
}

action fwd2host(dstAddr,port){
    modify_field(standard_metadata.egress_spec,port);
    modify_field(ethernet.dstAddr,dstAddr);
    modify_field(ethernet.etherType,0x0800);
}

field_list clone_filed{
    meta.dstAddr;
}

table clone_to_controller{
    actions{
        c2c;
    }
}

action c2c(){
    modify_field(meta.dstAddr,ethernet.dstAddr);
    clone_i2e(1,clone_filed);
}

table add_mri{
    actions{
      addmri;
    }
}

action addmri(){
    add_header(mri);
    modify_field(ipv4_option.option,2);
    modify_field(ethernet.etherType,0x801);
}

control ingress{
    if(ipv4_option.option==0){
      apply(add_routeid);
    }

    if((intrinsic_metadata.ingress_global_timestamp & 0x0A == 1) && (ipv4_option.count == 0)){
      apply(add_mri);
    }
    apply(routeid_fwd);
    if(ipv4_option.option==2){
        if((ipv4_option.count==4)||(ethernet.etherType==0x800)){
          apply(clone_to_controller);
        }
    }
}

control egress{
    if(ipv4_option.option==2){
        if(ipv4_option.count>=4){
          apply(add_mri5);
          }
        if(ipv4_option.count==3){
          apply(add_mri4);
          }
        if(ipv4_option.count==2){
          apply(add_mri3);
          }
        if(ipv4_option.count==1){
          apply(add_mri2);
          }
        if(ipv4_option.count==0){
          apply(add_mri1);
          }
        if((standard_metadata.instance_type==0) &&(ethernet.etherType==0x800)){
          apply(remove_int_t);
          }
        if(standard_metadata.instance_type==2){
          apply(mirror);
          }
    }
    apply(add_count);
}

table add_count{
    actions{
      addcount;
    }
}

action addcount(){
    add_to_field(ipv4_option.count,+1);
}

table mirror{
    actions{
        update_mri;
    }
}

action update_mri(){
    modify_field(ethernet.dstAddr,meta.dstAddr);
}

table remove_int_t{
    actions{
        remove_int;
    }
}

action remove_int(){
    remove_header(mri);
}

table add_mri1{
    actions{
        addmri1;
    }
}

action addmri1(swid){
    modify_field(mri.swid1,swid);
    modify_field(mri.qdepth1,queueing_metadata.deq_timedelta);
    modify_field(mri.timestamp1,queueing_metadata.enq_timestamp);
}

table add_mri2{
    actions{
        addmri2;
    }
}

action addmri2(swid){
    modify_field(mri.swid2,swid);
    modify_field(mri.qdepth2,queueing_metadata.deq_timedelta);
    modify_field(mri.timestamp2,queueing_metadata.enq_timestamp);
}

table add_mri3{
    actions{
        addmri3;
    }
}

action addmri3(swid){
    modify_field(mri.swid3,swid);
    modify_field(mri.qdepth3,queueing_metadata.deq_timedelta);
    modify_field(mri.timestamp3,queueing_metadata.enq_timestamp);
}

table add_mri4{
    actions{
        addmri4;
    }
}

action addmri4(swid){
    modify_field(mri.swid4,swid);
    modify_field(mri.qdepth4,queueing_metadata.deq_timedelta);
    modify_field(mri.timestamp4,queueing_metadata.enq_timestamp);
}

table add_mri5{
    actions{
        addmri5;
    }
}

action addmri5(swid){
    modify_field(mri.swid5,swid);
    modify_field(mri.qdepth5,queueing_metadata.deq_timedelta);
    modify_field(mri.timestamp5,queueing_metadata.enq_timestamp);
}
