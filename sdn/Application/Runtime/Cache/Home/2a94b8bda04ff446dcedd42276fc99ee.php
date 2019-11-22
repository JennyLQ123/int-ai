<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>sdn演示</title>

    <style type="text/css">
        html, body {
            font: 15pt arial;
        }

        h1 {
            font-size: 150%;
            margin: 5px 0;
        }

        h2 {
            font-size: 100%;
            margin: 5px 0;
        }

        table.view {
            width: 100%;
        }

        /*table td {*/
            /*!*vertical-align: top;*!*/
            /*text-align: center;*/
        /*}*/

        /*table table {*/
            /*background-color: #f5f5f5;*/
            /*border: 1px solid #e5e5e5;*/
        /*}*/

        /*table table td {*/
            /*vertical-align: middle;*/
        /*}*/

        input[type=text], pre {
            border: 1px solid lightgray;
        }

        pre {
            margin: 0;
            padding: 5px;
            font-size: 10pt;
        }

        .rect {
            /*width: 100%;*/
            height: 500px;
            border: 1px solid lightgray;
        }
        h4,.packet1{
            text-align: center;
        }
        input[type="text"]{
            margin:5px;
        }
        .pack1[type="text"]{
            margin-left: 35px;
        }

    </style>

    <script type="text/javascript" src="/sdn/Public/vis/vis.js"></script>
    <!--表格-->
    <link rel="stylesheet" href="/sdn/Public/Home/application.css">
    <link rel="stylesheet" href="/sdn/Public/Home/tables/jquery.dataTables.min.css">
    <script src="/sdn/Public/Home/tables/jquery-1.12.4.js"></script>
    <script src="/sdn/Public/Home/tables/jquery.dataTables.min.js"></script>
    <!--echart-->
    <script src="/sdn/Public/echart/echarts.min.js"></script>
    <!--network-->
    <link href="/sdn/Public/vis/vis-network.min.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
//        $(document).ready(function() {
//            $('#example').DataTable( {
//                "scrollY": 200,
//                "scrollX": true,
////                    "bFilter": false,
//            } );
//        });
    </script>
    <script type="text/javascript">

        var nodes, edges, network;

        // convenience method to stringify a JSON object
        function toJSON(obj) {
            return JSON.stringify(obj, null, 4);
        }

        function addNode() {
            try {
                nodes.add({
                    id: document.getElementById('node-id').value,
                    label: document.getElementById('node-label').value
                });
            }
            catch (err) {
                alert(err);
            }
        }

        function updateNode() {
            try {
                nodes.update({
                    id: document.getElementById('node-id').value,
                    label: document.getElementById('node-label').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
        function removeNode() {
            try {
                nodes.remove({id: document.getElementById('node-id').value});
            }
            catch (err) {
                alert(err);
            }
        }

        function addEdge() {
            try {
                edges.add({
                    id: document.getElementById('edge-id').value,
                    from: document.getElementById('edge-from').value,
                    to: document.getElementById('edge-to').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
        function updateEdge() {
            try {
                edges.update({
					width:3,
                    id: document.getElementById('edge-id').value,
                    from:document.getElementById('edge-from').value,
                    to: document.getElementById('edge-to').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
		//----------------------------------------------------
		function updateEdge1(path_id,start,end,path_color) {
		//---------要映射的	
            try {
                edges.update({
					width:3,
                    id: path_id,//document.getElementById('edge-id').value,
                    from:start+1,//document.getElementById('edge-from').value,
                    to: end+1,//document.getElementById('edge-to').value
					color:{color:path_color}
                });
            }
            catch (err) {
                alert(err);
            }
        }
		//-------------------------------
		function duiying(path_arr1,path_arr2){
			//draw();
			duiying1(all_path1,all_path2,all_path3);
			duiying_arr(path_arr1,"red");
			duiying_arr(path_arr2,"green");

		}
		function duiying_first(path_arr1,path_arr2){
			//draw();
			//duiying1(all_path1,all_path2,all_path3);
			duiying_arr(path_arr1,"red");
			duiying_arr(path_arr2,"green");

		}
		function duiying_arr(path_arr1,path_color){
			for( var path_i=0;path_i<path_arr1.length-1;path_i++){
				  if(path_arr1[path_i]!=0 && path_arr1[path_i+1]!=0 ){
						if(path_arr1[path_i]>path_arr1[path_i+1]){
								path_id = path_dict[path_arr1[path_i+1]+"_"+path_arr1[path_i]];
								updateEdge1(path_id,path_arr1[path_i+1],path_arr1[path_i],path_color);
							
						}else{
							path_id = path_dict[path_arr1[path_i]+"_"+path_arr1[path_i+1]];
							updateEdge1(path_id,path_arr1[path_i],path_arr1[path_i+1],path_color);
						}
						//console.log(path_id);
				  }else{
					path_i = path_arr1.length;
				  }
					
				}
		}
		function duiying1(all_path1,all_path2,all_path3){
			duiying1_arr(all_path1,"#4189eb");
			duiying1_arr(all_path2,"#4189eb");
			duiying1_arr(all_path3,"#4189eb");
		
		}
		function duiying1_arr(path_arr1,path_color){
			for( var path_i=0;path_i<path_arr1.length-1;path_i++){
			
				if(path_arr1[path_i]>path_arr1[path_i+1]){
						path_id = path_dict[path_arr1[path_i+1]+"_"+path_arr1[path_i]];
						updateEdge1(path_id,path_arr1[path_i+1],path_arr1[path_i],path_color);
					
				}else{
					path_id = path_dict[path_arr1[path_i]+"_"+path_arr1[path_i+1]];
					updateEdge1(path_id,path_arr1[path_i],path_arr1[path_i+1],path_color);
				}
			//	console.log(path_id);
		 
					
			}
		}
		
		
		//-----------------------------------
        function removeEdge() {
            try {
                edges.remove({id: document.getElementById('edge-id').value});
            }
            catch (err) {
                alert(err);
            }
        }

        function draw() {
            // create an array with nodes
            nodes = new vis.DataSet();
//            nodes.on('*', function () {
//                document.getElementById('nodes').innerHTML = JSON.stringify(nodes.get(), null, 4);
//            });
            nodes.add([
                {id: '1', label: 'S0',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '2', label: 'S1',shape: 'image', font:'16px',size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '3', label: 'S2',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '4', label: 'S3',shape: 'image', font:'16px',size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '5', label: 'S4',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '6', label: 'S5',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '7', label: 'S6',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '8', label: 'S7',shape: 'image', font:'16px',size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '9', label: 'S8',shape: 'image',font:'16px', size: 30,image: '/sdn/Public/img/switch.svg'},
                {id: '10', label: 'S9',shape: 'image', font:'16px',size: 30,image: '/sdn/Public/img/switch.svg'}
            ]);

            // ---------create an array with edges--------------------------
            edges = new vis.DataSet();
//            edges.on('*', function () {
//                document.getElementById('edges').innerHTML = JSON.stringify(edges.get(), null, 4);
//            });
            edges.add([
                {id: '1', width:3,from: '1', to: '2'},
                {id: '2',  width:3,from: '1', to: '4'},
                {id: '3',  width:3,from: '1', to: '9'},
                {id: '4', width:3, from: '2', to: '4'},
                {id: '5',  width:3,from: '2', to: '5'},
                {id: '6',  width:3,from: '2', to: '3'},
                {id: '7', width:3, from: '3', to: '5'},
                {id: '8',  width:3,from: '3', to: '10'},
                {id: '9', width:3, from: '4', to: '9'},
                {id: '10', width:3, from: '4', to: '7'},
                {id: '11',  width:3,from: '4', to: '6'},
                {id: '12',  width:3,from: '5', to: '10'},
                {id: '13', width:3, from: '5', to: '6'},//,color:{color:'red'}
                {id: '14',  width:3,from: '5', to: '8'},
                {id: '15', width:3, from: '6', to: '7'},
                {id: '16',  width:3,from: '6', to: '8'},
                {id: '17', width:3, from: '7', to: '8'},
                {id: '18',  width:3,from: '7', to: '9'},
                {id: '19',  width:3,from: '8', to: '10'},


            ]);

            // create a network
            var container = document.getElementById('network');
            var data = {
                nodes: nodes,
                edges: edges
            };
            var options = {};
            network = new vis.Network(container, data, options);

        }

    </script>

</head>

<body onload="draw();">
    <!--变量定义，数据获取函数-->
    <script>
		var path_dict={
		"0_1":"1",
		"0_3":"2",
		"0_8":"3",
		"1_3":"4",
		"1_4":"5",
		"1_2":"6",
		"2_4":"7",
		"2_9":"8",
		"3_8":"9",
		"3_6":"10",
		"3_5":"11",
		"4_9":"12",
		"4_5":"13",
		"4_7":"14",
		"5_6":"15",
		"5_7":"16",
		"6_7":"17",
		"6_8":"18",
		"7_9":"19",
		};
		var path_arr3=[2,1,3,5,7];
		var path_arr4=[2,9,7,0,0];
		var all_path1=[0,1,2,9,7,6,8,3,6,5,7,4,9];
		var all_path2=[2,4,1,3,0];
		var all_path3 = [3,5,4];
        var pack1=[];
        var pack2=[];
        var time1=[];
        var data1=[];
        var data11=[];
        var data12=[];
        var data13=[];
        var data14=[];
        var data15=[];
        var data4 = [];
        var timef1;

        function readdata() {
            $.ajax({
                type: 'post',
                url:"/sdn/index.php/Home/Data/rec",
                async:false,
                success: function(data,status){
                    //console.log(data);
                    $result = data.replace(/'/g,"\"");
                    $result = JSON.parse($result);
                    console.log($result);
                    var myDate=new Date();
                    timef1=myDate.toLocaleTimeString();//val["time"];//
                    time1.push(timef1);
                    data11.push($result["1"][ "qtimedelta"]);
                    data12.push($result["3"][ "qtimedelta"]);
                    data13.push($result["4"][ "qtimedelta"]);
                    data14.push($result["5"][ "qtimedelta"]);
                    data15.push($result["9"][ "qtimedelta"]);
                    //把所有都写这里，只要请求一次？？
                    data4.push($result["12"]);
                    data4.push($result["13"]);
                    data4.push($result["24"]);
                    data4.push($result["29"]);
                    data4.push($result["35"]);
                    data4.push($result["57"]);
                    data4.push($result["47"]);
                    data4.push($result["79"]);
                    pack1.push(($result["raw_info"]["0"]==null || $result["raw_info"]["0"]["swid"]==null)?"无":$result["raw_info"]["0"]["swid"]);
                    pack1.push(($result["raw_info"]["0"]==null || $result["raw_info"]["0"]["deqlen"]==null)?"无":$result["raw_info"]["0"]["deqlen"]);
                    pack1.push(($result["raw_info"]["0"]==null || $result["raw_info"]["0"]["delta"]==null)?"无":$result["raw_info"]["0"]["delta"]);

                    pack2.push(($result["raw_info"]["4"]==null || $result["raw_info"]["4"]["swid"]==null)?"无":$result["raw_info"]["4"]["swid"]);
                   // console.log($result["raw_info"]["6"]["swid"]);
                    pack2.push(($result["raw_info"]["4"]==null || $result["raw_info"]["4"]["deqlen"]==null)?"无":$result["raw_info"]["4"]["deqlen"]);
                    pack2.push(($result["raw_info"]["4"]==null || $result["raw_info"]["4"]["delta"]==null)?"无":$result["raw_info"]["4"]["delta"]);
					//console.log(pack1[0]);
					//console.log(pack2[0]);
                },error:function(){
					console.log("error_read");
				}
            });

        }
        function find_max_data(data_arr) {
            var max_data= data_arr[0];

            for(var i=0;i<data_arr.length;i++){
                if(data_arr[i]>max_data){
                    max_data = data_arr[i];
                }
            }
           // console.log("max_data  "+max_data);
            return max_data;
        }
		function bouncer(arr){
			return arr.filter(function(val){
				return !(!val || val==="");
			});
		}
    </script>
    <div style="margin:10px">
        <!--暂且不要-->
        <table>
        <!--<tr>-->
            <!--<td>-->
                <!--<h2>Node</h2>-->
                <!--<table>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td><label for="node-id">Id</label></td>-->
                        <!--<td><input id="node-id" type="text" value="6"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td><label for="node-label">Label</label></td>-->
                        <!--<td><input id="node-label" type="text" value="Node 6"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td>Action</td>-->
                        <!--<td>-->
                            <!--<button id="node-add" onclick="addNode();">Add</button>-->
                            <!--<button id="node-update" onclick="updateNode();">Update</button>-->
                            <!--<button id="node-remove" onclick="removeNode();">Remove</button>-->
                        <!--</td>-->
                    <!--</tr>-->
                <!--</table>-->
            <!--</td>-->
            <!--<td>-->
                <!--<h2>Edge</h2>-->
                <!--<table>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td><label for="edge-id">Id</label></td>-->
                        <!--<td><input id="edge-id" type="text" value="5"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td><label for="edge-from">From</label></td>-->
                        <!--<td><input id="edge-from" type="text" value="3"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td><label for="edge-to">To</label></td>-->
                        <!--<td><input id="edge-to" type="text" value="4"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                        <!--<td></td>-->
                        <!--<td>Action</td>-->
                        <!--<td>-->
                            <!--<button id="edge-add" onclick="addEdge();">Add</button>-->
                            <!--<button id="edge-update" onclick="updateEdge();">Update</button>-->
                            <!--<button id="edge-remove" onclick="removeEdge();">Remove</button>-->
                        <!--</td>-->
                    <!--</tr>-->
                <!--</table>-->
            <!--</td>-->
        <!--</tr>-->

    </table>
        <!--第一行网络图-->
        <table style="margin-top:10px" class="view">
            <colgroup>
                <col width="50%">
                <col width="50%">
                <!--<col width="25%">-->
            </colgroup>
            <tr>
                <td>
                    <h3>Topo
					<input type="text" placeholder="修改rules"/>
                    <button type="button" onclick="edit_rules()">提交</button>
					</h3>
                    
					<script>
						function edit_rules(){
							 $.ajax({
								type: 'post',
								url:"/sdn/index.php/Home/Data/send",
								async:false,
								success: function(data,status){
									console.log("修改rules成功！");
								}
							});
						}
					</script>
                    <div id="network" class="rect">

                    </div>


                </td>
                <td>
                    <h3>原始INT信息</h3>
                    
                    <div id="packet" class="rect">
                        <h4  style="margin-top:30px;">采样数据一</h4>
                        <div class="packet1">
                        <div>路径：<input type="text" class="pack pack1" name="path1" value=""/></div>
                        <div>队列深度：<input type="text" class="pack" name="dep1" value=""/></div>
                        <div>排队时延：<input type="text" class="pack" name="delay1" value=""/></div>
                        </div>
                        <h4>采样数据二</h4>
                        <div class="packet1">
                        <div>路径：<input type="text" class="pack pack1" name="path2" value=""/></div>
                        <div>队列深度：<input type="text" class="pack" name="dep2" value=""/></div>
                        <div>排队时延：<input type="text" class="pack" name="delay2" value=""/></div>
                        </div>
                    </div>
                    <script type="text/javascript">
						
						readdata();
						document.getElementsByName("path1")[0].value=pack1[0];
						document.getElementsByName("path2")[0].value=pack2[0];
						document.getElementsByName("dep1")[0].value=pack1[1];
						document.getElementsByName("dep2")[0].value=pack2[1];
						document.getElementsByName("delay1")[0].value=pack1[2];
						document.getElementsByName("delay2")[0].value=pack2[2];
						//同时修改network
						duiying_first(pack1[0],pack2[0]);	
						pack1.splice(0,pack1.length);
						pack2.splice(0,pack2.length);
						
                        setInterval(function () {
							//console.log("1");
                            readdata();
							
                          
                            document.getElementsByName("path1")[0].value=pack1[0];
                            document.getElementsByName("path2")[0].value=pack2[0];
                            document.getElementsByName("dep1")[0].value=pack1[1];
                            document.getElementsByName("dep2")[0].value=pack2[1];
                            document.getElementsByName("delay1")[0].value=pack1[2];
                            document.getElementsByName("delay2")[0].value=pack2[2];
							//同时修改network
							duiying(pack1[0],pack2[0]);
							
							
                            pack1.splice(0,pack1.length);
                            pack2.splice(0,pack2.length);

                            //设置input
                        }, 5000);

                    </script>
                </td>

            </tr>
        </table>
        <!--第二行-->
        <table style="margin-top:10px" class="view">
            <colgroup>
                <col width="50%">
                <col width="50%">
            </colgroup>


            <tr>
                <td>
                    <h3>排队时延<input type="text" placeholder="选择交换机" value="s1,s3,s4,s5,s9"/>
                    <button type="button" onclick="edit_sw()">提交</button></h3>
                    
                    <div id="delay" class="rect">

                    </div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart10 = echarts.init(document.getElementById('delay'));
                        //readdata1没用
                        function readdata1(){
                            $.ajax({
                                type: 'post',
                                url:"/sdn/index.php/Home/Data/delay",
                                async:false,
                                data:{"action":action},
                                success: function(data,status){

                                    $result = JSON.parse(data);
                                   // $.each($result,function(i,val){
                                        console.log($result);
                                        var myDate=new Date();
                                        timef1=myDate.toLocaleTimeString();//val["time"];
//
//                                        //timef1=timef1.substring(11,22);
//
                                        time1.push(timef1);
//                                        console.log(time1);
                                        //console.log($result["7"][ "qtimedelta"]);

                                        data11.push($result["1"][ "qtimedelta"]);
                                        data12.push($result["3"][ "qtimedelta"]);
                                        data13.push($result["5"][ "qtimedelta"]);
                                        data14.push($result["7"][ "qtimedelta"]);
                                        data15.push($result["9"][ "qtimedelta"]);
                                  //  });

                                },
                                error: function(data,status){
                                    alert("reddata1请求失败");
                                    console.log("read sdndn_link data error!!!");
                                }
                            });
                        }

                        option = {
                            title: {
                                //    text: '动态数据 + 时间坐标轴'
                            },
                            grid:{
                                show: false,
                                left: '10%',
                                right: '10%',
                                top: 40,
                                bottom: 40,
//                                borderColor: '#ccc',
                                borderWidth: 2,
                            },
                            tooltip: {
                                trigger: 'axis',
                                axisPointer: {
                                    animation: false
                                }
                            },
                            xAxis: {
                                type: 'category',
                                data:time1,
                                name:"时间",
								nameTextStyle:{
									fontSize:18
								},
                                splitLine: {
                                    show: false
                                },
                                axisTick: {
                                    alignWithLabel: true    //显示坐标轴刻度
                                },
                                axisLine:{
                                    show: true,       //显示坐标轴
                                    lineStyle:{
                                        //color: '#ccc',    //坐标轴颜色
                                        width: 2      //宽度
                                    }
                                },
								axisLabel: {
                                   rotate:5,
								  textStyle:{
										fontSize:18,
									}
								 },
                            },
                            yAxis: {
                                type: 'value',
                                max: '220',
                                name:"排队时延(us)",
								nameLocation:"end",
								nameTextStyle:{
									fontSize:18
								},
                                splitLine: {
                                    show: false
                                },
                                axisTick: {
                                    alignWithLabel: true    //显示坐标轴刻度
                                },
                                axisLine:{
                                    show: true,       //显示坐标轴
                                    lineStyle:{
                                        //color: '#ccc',    //坐标轴颜色
                                        width: 2      //宽度
                                    }
                                },
								axisLabel: {
                                   
										  textStyle:{
												fontSize:18,
											}
								
                            },
							},
                            series: [{
                                name: 's1',
                                type: 'line',
                                showSymbol: false,
                                hoverAnimation: false,
								itemStyle:{
									normal:{
										color:"#f00",
										width:2,
									},
								},
                                data: data11
                                //data:Math.random()*80000
                            },{
                                name: 's3',
                                type: 'line',
                                showSymbol: false,
                                hoverAnimation: false,
								itemStyle:{
									normal:{
										color:"#0f0",
										width:2,
									},
								},
                                data: data12
                                //data:Math.random()*80000
                            },{
							    
                                name: 's4',
                                type: 'line',
                                showSymbol: false,
                                hoverAnimation: false,
								itemStyle:{
									normal:{
										color:"#00f",
										width:2,
									},
								},
                                data: data13
                                // data:Math.random()*80000
                            },{
                                name: 's5',
                                type: 'line',
                                showSymbol: false,
                                hoverAnimation: false,
								itemStyle:{
									normal:{
										color:"#da70d6",
										width:2,
									},
								},
                                data: data14
                                //data:Math.random()*80000
                            },{
                                name: 's9',
                                type: 'line',
                                showSymbol: false,
                                hoverAnimation: false,
								itemStyle:{
									normal:{
										color:"#b8860d",
										width:2,
									},
								},
                                data: data15
								
                                //data:Math.random()*80000
                            }]
                        };
                        //ysyreaddata1();
                        //readdata1();
                        myChart10.setOption(option);
                        function edit_sw(){
							//        
							var data_arr=[find_max_data(bouncer(data11)),find_max_data(bouncer(data12)),find_max_data(bouncer(data13)),
										find_max_data(bouncer(data14)),find_max_data(bouncer(data15))];
							myChart10.setOption({
									legend:{
										data:['s1','s3','s4','s5','s9']
									},
									xAxis: {
										 data:time1
										 },
									yAxis: {
										type: 'value',
										max:'400'// Math.round(find_max_data(data_arr))+200,//

									},
								   series: [{
										   data:data11
									  },{
										   data:data12
									  },{
										   data:data13
									  },{
										   data:data14
									  },{
										   data:data15
									  }]
								   });							


							//通过设置setInterval控制循环取数
							setInterval(function () {
									//readdata1();
									if(data11.length>10){
										data11.shift();
										data12.shift();
										data13.shift();
										data14.shift();
										data15.shift();
										time1.shift();
									}
									console.log(bouncer(data11));
									var data_arr=[find_max_data(bouncer(data11)),find_max_data(bouncer(data12)),find_max_data(bouncer(data13)),
										find_max_data(bouncer(data14)),find_max_data(bouncer(data15))];
									console.log(data_arr);
									//console.log(find_max_data(data_arr));

								console.log(time1);
								myChart10.setOption({
								legend:{
										data:['s1','s3','s4','s5','s9']
									},
									xAxis: {
										 data:time1
										 },
									yAxis: {
										type: 'value',
										max: Math.round(find_max_data(bouncer(data_arr)))+50,//
										

									},
								   series: [{
										   data:data11
									  },{
										   data:data12
									  },{
										   data:data13
									  },{
										   data:data14
									  },{
										   data:data15
									  }]
								   });
	//                        	   data11.splice(0,data11.length);
	//                             data12.splice(0,data12.length);
	//                        	   data13.splice(0,data13.length);
	//                        	   data14.splice(0,data14.length);
	//                        	   data15.splice(0,data15.length);
	//                        	   time1.splice(0,time1.length);
							}, 5000);
						
						
						}

                    </script>
                </td>
                <td>
                    <h3>链路字节<input type="text" placeholder="选择链路" value="s1-s2,s1-s3,s2-s4,s2-s9,s3-s5,s5-s7,s4-s7,s7-s9"/>
                    <button type="button" onclick="edit_link()">提交</button></h3>
                    
                    <div id="link" class="rect">
                    </div>
                    <script type="text/javascript">

                        var myChart4 = echarts.init(document.getElementById('link'));

                        // 指定图表的配置项和数据
                        myChart4.setOption({
                            //         title: {
                            //             text: 'CPU占用率'
                            //        },
                            tooltip: {
                                axisPointer: {
                                    animation: false
                                }
                            },
                            //        legend: {
                            //            data:['销量']
                            //        },
                            //柱状图位置设置
                            grid:{
                                show: false,
                                left: '13%',
                                right: '10%',
                                top: 40,
                                bottom: 40,
//                                borderColor: '#ccc',
                                borderWidth: 2,
                            },
                            color: ['#5192EB','blue'],
                            //x轴坐标
                            xAxis: {
                                show: true,
                                type : 'category',
                                name:"链路",
								nameTextStyle:{
									fontSize:18
								},
                                data : ['','','','','','','',''],
                                splitLine:{show: false},//去除网格线
                                axisTick: {
                                    alignWithLabel: true    //显示坐标轴刻度
                                },
                                axisLine:{
                                    show: true,       //显示坐标轴
                                    lineStyle:{
//                                        color: '#ccc',    //坐标轴颜色
                                        width: 2      //宽度
                                    }
                                },
							   axisLabel: {
                                    rotate:20,
									textStyle:{
										fontSize:18,
									}
                                },
                            },
                            yAxis: {
                                show: true,
                                type: 'value',
                                max: '25000',
                                name:"链路字节数(Byte)",
								nameLocation:"end",
								nameTextStyle:{
									fontSize:18
								},
                                axisLabel: {
                                    formatter: '{value}',
									textStyle:{
										fontSize:'18',
									}
                                },
                                splitLine:{show: false},//去除网格线
                                axisLine:{
                                    show: true,
                                    lineStyle:{
//                                        color: '#ccc',
                                        width: 2
                                    }
                                }
                            },
                            series: [{
                                name: 'CPU占用率',
                                type: 'bar',       //柱形图
                                data: data4,
                                itemStyle:{
                                    normal:{
                                        //color: ['#5192EB','blue','blue','blue','blue','blue'],
//                                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
//                                            offset: 0,
//                                            color: 'red'
//                                        }, {
//                                            offset: 1,
//                                            color: 'orange'
//                                        }]),
                                    }},
                                barWidth: 20    //bar宽度
                            }

                            ],
                        });
//                        setInterval(function(){
//                            myChart4.setOption({
//                                series: [{
//                                    data: [Math.random()*60,Math.random()*60,Math.random()*60,Math.random()*60,Math.random()*60,Math.random()*60]
//                                }]
//                            });
//                        },3000);
//                        data4.splice(0,data4.length);
                   

                        window.addEventListener('resize', function () {
                            myChart4.resize();
                        });
						function edit_link(){
							myChart4.setOption({
								   yAxis: {
                                           type: 'value',
                                           max: Math.round(find_max_data(data4))+2000,//
                                       },
									   xAxis:{
									      axisLabel: {
                                   
										  textStyle:{
												fontSize:18,
											}
										   },
										data : ['s1-s2','s1-s3','s2-s4','s2-s9','s3-s5','s5-s7','s4-s7','s7-s9'],
								   },
								   });
						     setInterval(function () {
                                   //readdata;
                                   console.log(find_max_data(data4));
                                    //find_max_data(data4);
                                   myChart4.setOption({
                                       yAxis: {
                                           type: 'value',
                                           max: Math.round(find_max_data(data4))+2000,//
                                       },xAxis:{
											axisLabel: {
                                   
											  textStyle:{
													fontSize:18,
												}
										   },
											data : ['s1-s2','s1-s3','s2-s4','s2-s9','s3-s5','s5-s7','s4-s7','s7-s9'],
									   },
                                   series: [{
                                   data: data4
                                    }]
                                    });
                                    data4.splice(0,data4.length);
                                 }, 5000);
						
						
						}
                    </script>
                </td>

                <!--<td>-->
                <!--<h2>Edges</h2>-->
                <!--<pre id="edges"></pre>-->
                <!--</td>-->
            </tr>
        </table>
        <!--按钮
        <div style="margin:10px">
            <button class="btn leftbtn  btn-info" type="button" onclick="index_refresh()"><i class="icon-search"></i>刷新</button>
        </div>-->
        <!--放数据-->
        <div style="margin-top: 10px;display: none">
            <form name="myform" id="pageForm" method="post">
            <!--<input id="task_name" name="task_name" class="form-control textwidth kep" placeholder="任务名称" type="text">-->
            <!--3.3从数据库拿来的表格数据-->
            <table id="example" class="display nowrap" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>排队时延</th>
                    <th>离开时的队列深度</th>
                    <!--<th>周期内交换机处理的数据包数量</th>-->
                </tr>
                </thead>
                <tbody id="tbody">
                    <!--<tr>-->
                        <!--<td style="width:25%">1</td>-->
                        <!--<td style="width:25%">1</td>-->
                        <!--<td style="width:25%">1</td>-->
                        <!--<td style="width:25%">1</td>-->
                    <!--</tr>-->
                </tbody>
            </table>
            </form>
        </div>
        <script>
           // index_search();
            function  index_search(){
                $.ajax({
                    type: 'post',
                    url: '/sdn/index.php/Home/Index/index_search',
                    cache: false,
                    async: false,
                    data: $('#pageForm').serialize(),
                    dataType: "json",
                    success: function (data) {
                        $result = JSON.parse(data);
                        //console.log($result);
                        //console.log($result["int_receive"]);
                        if (data=='false') {
                            alert('查询失败');
                        } else{
                            $('#tbody').empty();
                            table = $('#example').dataTable();
                            table.fnClearTable(); //清空一下table
                            table.fnDestroy();//还原初始化了的datatable

                            $.each($result["int_receive"],function(i,val){
                                $str='';
                                $str = $str + '<tr>';
                                $str = $str + '<td> '+i+'</td>';//<input name="ids" class="ids" value="'+val.counter+'" type="checkbox" style="margin-top: 0px;">
                                $str = $str + '<td> '+val.qtimedelta+' </td>';
                                $str = $str + '<td> '+val.depth+' </td>';
//                                $str = $str + '<td> '+val.counter+' </td>';
                                $str = $str + '</tr>';
                                $('#tbody').append($str);
                            });

                            $('#example').DataTable( {
                                "scrollY": 200,
                                "scrollX": true,
                                "bFilter": false,
                                "language": {
                                    "emptyTable": "没有找到数据哦！"
                                }
                            } );

                        }


                    }, error: function () {
                        alert("error");
                    }
                });
            }
            //
            function index_refresh() {
				console.log("修改rules成功！");
				//alert("修改rules成功！");
            }

        </script>
    </div>
</body>
</html>