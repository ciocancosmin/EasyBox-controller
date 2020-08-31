boxes_nr = 0;
box_to_move = 0;
max_allowed_box_distance = 120;

global_mouse_x = 0;
global_mouse_y = 0;

global_mouse_offset_x = 0;
global_mouse_offset_y = 0;

is_ctrl_pressed = 0;
use_multiple_select = 0;

global_select_arr = [];
can_move_multiple_boxes = 0;

function enable_multiple_boxes_move(box)
{
	var target_box_id_nr = box.id.split("_")[1];
	var ok = 0;
	for (var i = 0; i < global_select_arr.length; i++) {
		if( global_select_arr[i] == target_box_id_nr)
		{
			ok = 1;
			break;
		}
	}
	if(ok) can_move_multiple_boxes = 1;
}

function disable_multiple_boxes_move()
{
	can_move_multiple_boxes = 0;	
}

function update_mouse_position(event)
{
	current_mouse_x = event.clientX;
	current_mouse_y = event.clientY;
	global_mouse_offset_x = current_mouse_x - global_mouse_x; 
	global_mouse_offset_y = current_mouse_y - global_mouse_y;
	global_mouse_x = current_mouse_x;
  	global_mouse_y = current_mouse_y;
  	//console.log(global_mouse_x+" "+global_mouse_y);
  	//console.log(global_mouse_offset_x+" "+global_mouse_offset_y);
}

function select_box(box)
{
	if( is_ctrl_pressed )
	{
		target_box_nr = box.id.split("_")[1];
		global_select_arr.push( target_box_nr );
		$("#"+box.id).css("border","2px dashed red");
		$("#"+box.id).attr("onclick","unselect_box(this);");
	}
	console.log(global_select_arr);
}

function unselect_box(box)
{
	if( is_ctrl_pressed )
	{
		target_box_nr = box.id.split("_")[1];
		
		for (var i = 0; i < global_select_arr.length; i++) {
			if( global_select_arr[i] == target_box_nr ) global_select_arr.splice(i,1);
		}

		$("#"+box.id).css("border","1px solid black");
		$("#"+box.id).attr("onclick","select_box(this);");
	}
	console.log(global_select_arr);
}

function ctrl_is_pressed(event)
{
	if(event.keyCode == 17) is_ctrl_pressed = 1;
}

function ctrl_is_not_pressed(event)
{
	if(is_ctrl_pressed) is_ctrl_pressed = 0;
}

function move_box(event,box_nr)
{

	var mouse_x = event.clientX - $('#box_edit').offset().left;
  	var mouse_y = event.clientY - $('#box_edit').offset().top;

  	var box_y = parseInt( $("#box_"+box_nr).css("top") );
  	var box_x = parseInt( $("#box_"+box_nr).css("left") );

  	var box_height = parseInt( $("#box_"+box_nr).css("height") );
  	var box_width = parseInt( $("#box_"+box_nr).css("width") );

  	//update box position
  	$("#box_"+box_nr).css("top", ( mouse_y - (box_height/2) ) + "px" );
  	$("#box_"+box_nr).css("left", ( mouse_x - (box_width/2) ) + "px" );

}

function move_selected_boxes()
{
	for (var i = 0; i < global_select_arr.length; i++) {
		current_box_id = "#box_"+global_select_arr[i];
		current_box_x = parseInt( $(current_box_id).css("left") );
		current_box_y = parseInt( $(current_box_id).css("top") );
		current_box_x += global_mouse_offset_x;
		current_box_y += global_mouse_offset_y;
		$(current_box_id).css("left", current_box_x + "px" );
		$(current_box_id).css("top", current_box_y + "px" ); 
	}
}

function get_distance(x1,y1,x2,y2)
{
	return Math.sqrt( Math.pow(x1-x2,2) + Math.pow(y1-y2,2) );
}

function absolute_value(nr)
{
	return Math.sqrt( Math.pow(nr,2) );
}

function reposition_box(box_nr)
{

	current_box_x = parseInt( $("#box_"+box_nr).css("left") );
	current_box_y = parseInt( $("#box_"+box_nr).css("top") );

	//calculating the distance from the closest box

	boxes_distance_array = []

	for (var i = 1; i <= boxes_nr; i++) {
		
		temp_box_x = parseInt( $("#box_"+i).css("left") );
		temp_box_y = parseInt( $("#box_"+i).css("top") );

		if(i != box_nr)
		{
			boxes_distance = get_distance( current_box_x , current_box_y , temp_box_x , temp_box_y );
			//console.log(current_box_y + " " + current_box_x + " " + temp_box_x + " " + temp_box_y );
			var append_box = {
				nr:i,
				distance:boxes_distance
			};
			boxes_distance_array.push( append_box );
		}
		else
		{
			var append_box = {
				nr:i,
				distance:0.0
			};
			boxes_distance_array.push( append_box );
		}

	}

	boxes_distance_array.sort( function(a, b){return a.distance-b.distance} );
	boxes_distance_array.shift();

	target_box = boxes_distance_array[0].nr;
	target_box_distance = boxes_distance_array[0].distance;

	if( target_box_distance < max_allowed_box_distance )
	{

		var left_pos = parseInt( $("#box_"+box_nr).css("left") ) - parseInt( $("#box_"+target_box).css("left") );
		var top_pos = parseInt( $("#box_"+box_nr).css("top") ) - parseInt( $("#box_"+target_box).css("top") );

		if( absolute_value(left_pos) > absolute_value(top_pos) )
		{
			if(left_pos < 0)
			{
				$("#box_"+box_nr).css("left", parseInt( $("#box_"+target_box).css("left") ) - parseInt( $("#box_"+box_nr).css("width") ) + "px" );
				$("#box_"+box_nr).css("top", parseInt( $("#box_"+target_box).css("top") ) + "px" );
			}
			else
			{
				$("#box_"+box_nr).css("left", parseInt( $("#box_"+target_box).css("left") ) + parseInt( $("#box_"+target_box).css("width") ) + "px" );
				$("#box_"+box_nr).css("top", parseInt( $("#box_"+target_box).css("top") ) + "px" );
			}
		}
		else
		{
			if(top_pos < 0)
			{
				$("#box_"+box_nr).css("top", parseInt( $("#box_"+target_box).css("top") ) - parseInt( $("#box_"+box_nr).css("height") ) + "px" );
				$("#box_"+box_nr).css("left", parseInt( $("#box_"+target_box).css("left") ) + "px" );
			}
			else
			{
				$("#box_"+box_nr).css("top", parseInt( $("#box_"+target_box).css("top") ) + parseInt( $("#box_"+target_box).css("height") ) + "px" );
				$("#box_"+box_nr).css("left", parseInt( $("#box_"+target_box).css("left") ) + "px" );
			}
		}

	}

	console.log(boxes_distance_array);

}

function check_boxes(event)
{
	if(global_select_arr.length == 0)
	{
		if(box_to_move != 0) move_box(event,box_to_move);
	}
	else
	{
		if( can_move_multiple_boxes ) move_selected_boxes();
	}

}

function add_box( div_id )
{
	boxes_nr += 1;
	$("#"+div_id).html( $("#"+div_id).html() + '<div class="box" id="box_'+boxes_nr+'" onmouseup="box_to_move = 0;reposition_box('+boxes_nr+');disable_multiple_boxes_move();" onmousedown="box_to_move = '+boxes_nr+';enable_multiple_boxes_move(this);" onclick="select_box(this);"></div>');
}

$(document).ready(function(){
	//setInterval(function(){  }, 3000);
});