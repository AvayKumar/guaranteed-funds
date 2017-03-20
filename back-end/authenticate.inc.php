<?php
	
	session_start();

	function isAuthenticated() {
		return  isset($_SESSION['u_id']);
	}