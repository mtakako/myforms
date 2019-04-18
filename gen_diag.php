<html>
<head>
<?php
include_once("var.inc.php");
include_once("encodage.inc.php");
?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="alloy-3.0.1/build/aui-css/css/bootstrap.css">
    <script src="alloy-3.0.1/build/aui/aui.js"></script>

</head>
<?php
include_once("functions.inc.php");
$filename = $_POST['table'].".json";
?>
<body>

<script>
var diagramMyForms;
var diagram;
function valider(){
	document.forms["myforms"].myforms_workflow.value=JSON.stringify(diagram.toJSON());

	sep1="";
	sep2="";	
	sep3="";	
	diag = eval('(' + JSON.stringify(diagram.toJSON()) + ')');
	document.forms["myforms"].lesetapes.value='';
	document.forms["myforms"].lesetats.value='';
	document.forms["myforms"].tabetats.value='';
	document.forms["myforms"].tabetatstache.value='';
	for (var i = 0; i < diag.nodes.length; i++) {
		if (diag.nodes[i].type=='task'){
			document.forms["myforms"].lesetapes.value+=sep1 + diag.nodes[i].name;
			sep1="|";
		}
		if (diag.nodes[i].type=='state'){
			document.forms["myforms"].lesetats.value+=sep2 + diag.nodes[i].name;
			sep2="|";
		}
		if ((diag.nodes[i].type=='state')||(diag.nodes[i].type=='start')){

			if (diag.nodes[i].type=='start'){
				document.forms["myforms"].tabetats.value+=sep3 + 'START';
				document.forms["myforms"].tabetatstache.value+=sep3 + 'START';
			}
			else{
				document.forms["myforms"].tabetats.value+=sep3 + diag.nodes[i].name;
				document.forms["myforms"].tabetatstache.value+=sep3 + diag.nodes[i].name;
			}

			sep3="|";
			if (diag.nodes[i].transitions.length>0){
				for (var j = 0; j < diag.nodes.length; j++){
				// recup de la tache en target
					if ((diag.nodes[j].type=='task')&&(diag.nodes[j].name==diag.nodes[i].transitions[0].target)){
						//recup du nom de la tache en target
						document.forms["myforms"].tabetatstache.value+='=>'+diag.nodes[j].name;
						// recupt des etats de la target
						for (var k = 0; k < diag.nodes[j].transitions.length; k++){
							document.forms["myforms"].tabetats.value+='=>'+diag.nodes[j].transitions[k].target;

						}
					}
				}
			}
		}
	}

	document.forms["myforms"].action="colonne.php";
	document.forms["myforms"].submit();
}


</script>
<form name="myforms" method="post">
<input type="hidden" name="myforms_workflow">
<input type="hidden" name="database" value="<?php echo $_POST['database']?>">
<input type="hidden" name="table" value="<?php echo $_POST['table']?>">
<input type="hidden" size=90 name="lesetapes">
<input type="hidden" size=90 name="lesetats">
<input type="hidden" size=90 name="tabetats">
<input type="hidden" size=90 name="tabetatstache">
<input type="button" value="Enregistrer et configurer les &eacute;tapes" onclick="valider()">

</form>

<h1>MyForms Workflow</h1>
    <div id="diagrambuilderBB" class="diagram-builder">
        <div id="diagrambuilderCB" class="diagram-builder-content">

            <div class="tabbable">
                <div class="tabbable-content">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="javascript:;">Ajout de noeud</a></li>
                        <li><a href="javascript:;">Configuration</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane"></div>
                        <div class="tab-pane"></div>
                    </div>
                </div>
            </div>

            <div class="diagram-builder-content-container">
                <div class="diagram-builder-canvas">
                    <div class="diagram-builder-drop-container"></div>
                </div>
            </div>

        </div>
    </div>
    <script>
	YUI().use(
	  'aui-io-request',
	  function (Y) {
		Y.io.request(
		  '<?php echo $filename?>',
		  {
			on: {
			  success: function() {
				diagramMyForms = eval('(' + this.get('responseData') + ')');

			  }
			}
		  }
		);
	  }
	);
    
    
    YUI({ filter:'raw' }).use('aui-diagram-builder', function(Y) {

        var availableFields = [
            {
                type: 'task',
                label: 'Tache',
                iconClass: 'diagram-node-task-icon'
            },
				{
					iconClass: 'diagram-node-start-icon',
					label: 'Start',
					type: 'start'
				},
            {
                type: 'state',
                label: 'Etat',
                iconClass: 'diagram-node-state-icon'
            }
        ];


        diagram = new Y.DiagramBuilder({
            availableFields: availableFields,
            boundingBox: '#diagrambuilderBB',
            srcNode: '#diagrambuilderCB',
            fields: []
        }).render();
	
	diagram.connector._attrs.showName.value=false;

        
	for (var i = 0; i < diagramMyForms.nodes.length; i++) {
		diagram.addField({name: diagramMyForms.nodes[i].name,type: diagramMyForms.nodes[i].type,description: diagramMyForms.nodes[i].description,xy: [diagramMyForms.nodes[i].xy[0], diagramMyForms.nodes[i].xy[1]]});
	}
	for (var i = 0; i < diagramMyForms.nodes.length; i++) {
		for (var j = 0; j < diagramMyForms.nodes[i].transitions.length; j++) {
		        diagram.connect(diagramMyForms.nodes[i].transitions[j].source,diagramMyForms.nodes[i].transitions[j].target,diagramMyForms.nodes[i].transitions[j].connector);
		}
	}
    });
    </script>
</body>
</html>
