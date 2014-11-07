<?php 

/**
 * @desc allows a flexible schema to be defined and stored as json
 * this can be used to store custom fields on any object in a single db field
 */

/**
 * @desc - the schema is passed in as json e.g.
 *{
 *	"id":"product_meta",
 *	"fields":[
 *		{
 *			"name":"image",
 *			"type":"IMAGE",
 *			"label":"Main Image"
*		},
*		{
*			"name":"short_desc",
*			"type":"TEXT",
*			"label":
*			"Short Description"
*		},
*		{
*			"name":"tags",
*			"type":"ARRAY",
*			"label":"Blog post tags"
*		}
*	]
*}
 */
class flexi_schema {

	var $id;
	var $fields = Array();

	function __construct($json=''){
		if($json != ''){
			$this->loadFromJson($json);
		}
	}

	function loadFromJson($json){
		$data = json_decode($json);
		$this->fields = $data->fields;
	}

	function addField($field){
		$this->fields[] = $field;
	}

	function toJson(){
		return json_encode($this);
	}

}

class flexi_schema_field {

	var $name;
	var $type;

}

class flexi_schema_data {
	var $values = Array();

	function loadFromJson($json){
		$data = json_decode($json);
		if(is_object($data)){
			$this->values = $data->values;
		}
	}

	function loadFromForm($schema){
		foreach($schema->fields as $field){
			$this->values[$field->name] = getValue($field->name, 'post');
		}
	}

	function toJson(){
		return json_encode($this);
	}
}

?>