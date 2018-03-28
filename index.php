<?php
// Functions
include 'functions.php';

$token      = (isset($_GET['token'])) ? escape_text($_GET['token']) : false;

if($token && validToken($token)) {
	$request = ( isset( $_GET['request'] ) ) ? escape_text( $_GET['request'] ) : false;

	// API
	if ( $request ) {
		header( 'Content-Type: application/json' );
		switch ( $request ) {
			case 'read':
				$id   = ( isset( $_GET['id'] ) ) ? escape_text( $_GET['id'] ) : false;
				$page = ( isset( $_GET['page'] ) ) ? escape_text( $_GET['page'] ) : false;
				if ( $id ) {
					$id = intval( $id );
					if ( $page ) {
						$item = getItem( $id, $page );
					} else {
						$item = getItem( $id );
					}
				} else {
					if ( $page ) {
						$item = getItem( false, $page );
					} else {
						$item = getItem();
					}
				}
				echo json_encode( $item );
				break;
			case 'create':
				$name = ( isset( $_GET['name'] ) ) ? escape_text( $_GET['name'] ) : false;
				$desc = ( isset( $_GET['desc'] ) ) ? escape_text( $_GET['desc'] ) : false;
				$size = ( isset( $_GET['size'] ) ) ? escape_text( $_GET['size'] ) : false;
				$cost = ( isset( $_GET['cost'] ) ) ? escape_text( $_GET['cost'] ) : false;
				if ( $name && $desc && $size && $cost ) {
					echo insertItem( $name, $desc, $size, $cost );
				} else {
					echo '{"code": 400, "msg": "Error, empty fields"}';
				}
				break;
			case 'delete':
				$id = ( isset( $_GET['id'] ) ) ? escape_text( $_GET['id'] ) : false;
				if ( $id ) {
					echo deleteItem( $id );
				} else {
					echo '{"code": 400, "msg": "Error, empty fields"}';
				}
				break;
			case 'update':
				$id   = ( isset( $_GET['id'] ) ) ? escape_text( $_GET['id'] ) : false;
				$name = ( isset( $_GET['name'] ) ) ? escape_text( $_GET['name'] ) : false;
				$desc = ( isset( $_GET['desc'] ) ) ? escape_text( $_GET['desc'] ) : false;
				$size = ( isset( $_GET['size'] ) ) ? escape_text( $_GET['size'] ) : false;
				$cost = ( isset( $_GET['cost'] ) ) ? escape_text( $_GET['cost'] ) : false;
				if ( $id ) {
					echo updateItem( $id, $name, $desc, $size, $cost );
				} else {
					echo '{"code": 400, "msg": "Error, empty ID"}';
				}
				break;
			default:
				// Invalid Request Method
				echo '{"code": 400, "msg": "Invalid request"}';
				break;
		}
		die();
	}
	echo '{"code": 400, "msg": "Empty request"}';
	die();
}
echo '{"code": 400, "msg": "Invalid Token"}';
die();

