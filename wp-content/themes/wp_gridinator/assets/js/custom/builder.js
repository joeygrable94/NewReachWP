
var printTagIDandClasses = function(element) {
	// gather sequence vars
	let elementTag = element.tagName.toLowerCase(),
		elementClasses = element.classList || false,
		elementIDs = element.getAttribute("id") || false,
		querySelector = elementTag;
	// set id
	if (elementIDs) { querySelector += "#"+elementIDs; }
	// set elementClasses
	for (let i = 0; elementClasses && i < elementClasses.length; i++) {
			querySelector += "."+elementClasses[i];
	}
	// return querySelector
	return querySelector;
};


function tab() {
	return new String("    ");
}


function loopAndPrintTagIdClassArchitecture(element) {
	
	var output = "";
	output += printTagIDandClasses(element) + "\n";

	// check the initial node has children
	if (element.hasChildNodes()) {
		
		// get children
		var children = element.childNodes;
		
		// loop through each child
		for (var i = 0; i < children.length; i++) {
			
			// if the child is a node and it has more children
			if (children[i].nodeType === 1 && children[i].hasChildNodes()) {

				// recursively loop through DOM nodes
				loopAndPrintTagIdClassArchitecture(children[i]);

			} else {
				// tab this child element
				output += tab();
				// and print this childs tag-ID-class
				output += printTagIDandClasses(element) + "\n";
			}
		}
	}

	return output;

}



$(document).ready(function() {
	
	//console.log(loopAndPrintTagIdClassArchitecture(document.body));

});



