<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Network | DataSet</title>

    <style type="text/css">
        html, body {
            font: 11pt arial;
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

        table td {
            vertical-align: top;
        }

        table table {
            background-color: #f5f5f5;
            border: 1px solid #e5e5e5;
        }

        table table td {
            vertical-align: middle;
        }

        input[type=text], pre {
            border: 1px solid lightgray;
        }

        pre {
            margin: 0;
            padding: 5px;
            font-size: 10pt;
        }

        #network {
            width: 100%;
            height: 400px;
            border: 1px solid lightgray;
        }
    </style>

    <script type="text/javascript" src="/sdn/Public/vis/vis.js"></script>
    <link href="/sdn/Public/vis/vis-network.min.css" rel="stylesheet" type="text/css"/>

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
                    id: document.getElementById('edge-id').value,
                    from: document.getElementById('edge-from').value,
                    to: document.getElementById('edge-to').value
                });
            }
            catch (err) {
                alert(err);
            }
        }
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
            nodes.on('*', function () {
                document.getElementById('nodes').innerHTML = JSON.stringify(nodes.get(), null, 4);
            });
            nodes.add([
                {id: '1', label: 'Node 1',shape: 'image', size: 20,image: '/sdn/Public/img/controller_data.svg'},
                {id: '2', label: 'Node 2'},
                {id: '3', label: 'Node 3'},
                {id: '4', label: 'Node 4'},
                {id: '5', label: 'Node 5'}
            ]);

            // create an array with edges
            edges = new vis.DataSet();
            edges.on('*', function () {
                document.getElementById('edges').innerHTML = JSON.stringify(edges.get(), null, 4);
            });
            edges.add([
                {id: '1', from: '1', to: '2',color:{color:'red'}},
                {id: '2', from: '1', to: '3'},
                {id: '3', from: '2', to: '4'},
                {id: '4', from: '2', to: '5'}
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

<p>
    This example demonstrates dynamically adding, updating and removing nodes
    and edges using a DataSet.
</p>

<h1>Adjust</h1>
<table>
    <tr>
        <td>
            <h2>Node</h2>
            <table>
                <tr>
                    <td></td>
                    <td><label for="node-id">Id</label></td>
                    <td><input id="node-id" type="text" value="6"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label for="node-label">Label</label></td>
                    <td><input id="node-label" type="text" value="Node 6"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Action</td>
                    <td>
                        <button id="node-add" onclick="addNode();">Add</button>
                        <button id="node-update" onclick="updateNode();">Update</button>
                        <button id="node-remove" onclick="removeNode();">Remove</button>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <h2>Edge</h2>
            <table>
                <tr>
                    <td></td>
                    <td><label for="edge-id">Id</label></td>
                    <td><input id="edge-id" type="text" value="5"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label for="edge-from">From</label></td>
                    <td><input id="edge-from" type="text" value="3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><label for="edge-to">To</label></td>
                    <td><input id="edge-to" type="text" value="4"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Action</td>
                    <td>
                        <button id="edge-add" onclick="addEdge();">Add</button>
                        <button id="edge-update" onclick="updateEdge();">Update</button>
                        <button id="edge-remove" onclick="removeEdge();">Remove</button>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>

<h1>View</h1>
<table class="view">
    <colgroup>
        <col width="25%">
        <col width="25%">
        <col width="50%">
    </colgroup>
    <tr>
        <td>
            <h2>Nodes</h2>
            <pre id="nodes"></pre>
        </td>

        <td>
            <h2>Edges</h2>
            <pre id="edges"></pre>
        </td>

        <td>
            <h2>Network</h2>

            <div id="network"></div>
        </td>
    </tr>
</table>

</body>
</html>