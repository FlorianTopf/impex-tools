<?php

//@TODO introduce cronjob for that!


ini_set('memory_limit', '-1');

function sxml_append(SimpleXMLElement $to, SimpleXMLElement $from){
	$toDom = dom_import_simplexml($to);
	$fromDom = dom_import_simplexml($from);
	$toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
}

function create_field($attributes=array()){
	$field = new SimpleXMLElement('<FIELD></FIELD>');
	foreach($attributes as $key => $value){
		$field->addAttribute($key, $value);
	}
	return $field;
}

function create_header(){
	$table = new SimpleXMLElement('<TABLE></TABLE>');
	$table->addChild('DESCRIPTION', 'Venus Express Magnetometer Data');
	$col1 = create_field(array('name'=>'Time', 'ID'=>'col1',
			'ucd'=>'time.epoch','xtype'=>'dateTime',
			'utype'=>' ','datatype'=>'char','arraysize'=>'*'));
	sxml_append($table, $col1);
	$col2 = create_field(array('name'=>'B_SC_X', 'ID'=>'col2',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));	
	sxml_append($table, $col2);
	$col3 = create_field(array('name'=>'B_SC_Y', 'ID'=>'col3',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));
	sxml_append($table, $col3);
	$col4 = create_field(array('name'=>'B_SC_Z', 'ID'=>'col4',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));
	sxml_append($table, $col4);
	$col5 = create_field(array('name'=>'B_VSO_X', 'ID'=>'col5',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));
	sxml_append($table, $col5);
	$col6 = create_field(array('name'=>'B_VSO_Y', 'ID'=>'col6',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));
	sxml_append($table, $col6);
	$col7 = create_field(array('name'=>'B_VSO_Z', 'ID'=>'col7',
			'ucd'=>'phys.magField', 'utype'=>' ','datatype'=>'float',
			'unit'=>'nT'));
	sxml_append($table, $col7);
	$col8 = create_field(array('name'=>'POS_VSO_X', 'ID'=>'col8',
			'ucd'=>'pos.cartesian.x', 
			'utype'=>'stc:AstroCoords.Position3D.Value3.C1',
			'datatype'=>'float',));
	sxml_append($table, $col8);
	$col9 = create_field(array('name'=>'POS_VSO_Y', 'ID'=>'col9',
			'ucd'=>'pos.cartesian.y',
			'utype'=>'stc:AstroCoords.Position3D.Value3.C2',
			'datatype'=>'float',));
	sxml_append($table, $col9);
	$col10 = create_field(array('name'=>'POS_VSO_Z', 'ID'=>'col10',
			'ucd'=>'pos.cartesian.z',
			'utype'=>'stc:AstroCoords.Position3D.Value3.C3',
			'datatype'=>'float',));
	sxml_append($table, $col10);
	return $table;
}

function create_row($columns){
	$row = new SimpleXMLElement('<TR></TR>');
	foreach($columns as $column){
		if($column != '')
			$row->addChild('TD', $column);
	}
	return $row;
}

function create_table($dataset){
	$data = new SimpleXMLElement('<DATA></DATA>');
	$tabledata = new SimpleXMLElement('<TABLEDATA></TABLEDATA>');
	foreach($dataset as $columns){
		sxml_append($tabledata, create_row($columns));
	}
	sxml_append($data, $tabledata);
	return $data;
}

function csv_to_array($filename='', $delimiter=' '){
	if(!file_exists($filename) || !is_readable($filename)){
		return false;
	}
	$data = array();
	if(($handle = fopen($filename, 'r')) !== false){
		while(($row = fgetcsv($handle, 30000, $delimiter)) !== false){
			$data[] = $row;
		}
		fclose($handle);
	}
	return $data;
}

function process_dir($filedir=''){
	if($handle = opendir($filedir)){
		while (false !== ($entry = readdir($handle))){
			if(strpos($entry,'.dat') !== false){
				$filename = substr($entry, 0, strrpos($entry, '.')).".xml";
				if(!file_exists($filedir.$filename) || 
						!is_readable($filedir.$filename)){
					echo "Processing: $entry\n";
					$votable = new SimpleXMLElement('<VOTABLE></VOTABLE>');
					$votable->addAttribute('version', '1.2');
					$votable->addAttribute('xmlns', 'http://www.ivoa.net/xml/VOTable/v1.2');
					$resource = new SimpleXMLElement('<RESOURCE></RESOURCE>');
					$resource->addAttribute('name', 'vex_mag_data');
					$header = create_header();
					$data = csv_to_array($filedir.$entry);
					$table = create_table($data);
					sxml_append($header, $table);
					sxml_append($resource, $header);
					sxml_append($votable, $resource);
					$dom = dom_import_simplexml($votable)->ownerDocument;
					$dom->formatOutput = true;
					$dom->encoding ="UTF-8";
					$dom->save($filedir.$filename);
					echo "Saved to: $filename\n";
				}
			}
		}
	}
}

//process_dir('/Applications/XAMPP/htdocs/impex-service/VSO/');
process_dir('/home/amda-ftp/MAG/VSO/');

?>