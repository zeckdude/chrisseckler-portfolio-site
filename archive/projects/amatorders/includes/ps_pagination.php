<?php
/**
 * PHPSense Pagination Class
 *
 * PHP tutorials and scripts
 *
 * @package		PHPSense
 * @author		Jatinder Singh Thind
 * @copyright	Copyright (c) 2006, Jatinder Singh Thind
 * @link		http://www.phpsense.com
 */

// ------------------------------------------------------------------------


class PS_Pagination {
	var $php_self;
	var $rows_per_page = 10; //Number of records to display per page
	var $total_rows = 0; //Total number of rows returned by the query
	var $links_per_page = 5; //Number of links to display per page
	var $append = ""; //Paremeters to append to pagination links
	var $sql = "";
	var $debug = true;
	var $conn = false;
	var $page = 1;
	var $max_pages = 0;
	var $offset = 0;
	
	


	
	
	/**
	 * Constructor
	 *
	 * @param resource $connection Mysql connection link
	 * @param string $sql SQL query to paginate. Example : SELECT * FROM users
	 * @param integer $rows_per_page Number of records to display per page. Defaults to 10
	 * @param integer $links_per_page Number of links to display per page. Defaults to 5
	 * @param string $append Parameters to be appended to pagination links 
	 */
	
	function PS_Pagination($connection, $sql, $rows_per_page = 10, $links_per_page = 5, $append = "") {
		
		
		if(isset($_GET['searchby']) && !isset($_GET['sortby'])){ //If the GET variable search_submit is in the url
			$beginning_url = $_SERVER['PHP_SELF'];
			$beginning_url .= '?search_submit=1'; //then add this to the end of the url string
			$beginning_url .= '&searchby=' . urlencode($_GET['searchby']); //add whatever is currently in the GET searchby to the end of the url string
			$beginning_url .= '&search_input=' . urlencode($_GET['search_input']); //add whatever is currently in the GET search_input to the end of the url string
	   }
	   
	   if(!isset($_GET['searchby']) && isset($_GET['sortby'])){ //If the GET variable sortby is in the url
			$beginning_url = $_SERVER['PHP_SELF'];
			//$beginning_url .= '?search_submit=1'; //then add this to the end of the url string
			$beginning_url .= '?sortby=' . urlencode($_GET['sortby']); //add whatever is currently in the GET sortby to the end of the url string
	   }
	   
	   if(isset($_GET['searchby']) && isset($_GET['sortby'])){ //If the GET variable search_submit is in the url
			$beginning_url = $_SERVER['PHP_SELF'];
			$beginning_url .= '?search_submit=1'; //then add this to the end of the url string
			$beginning_url .= '&searchby=' . urlencode($_GET['searchby']); //add whatever is currently in the GET searchby to the end of the url string
			$beginning_url .= '&search_input=' . urlencode($_GET['search_input']); //add whatever is currently in the GET search_input to the end of the url string
			$beginning_url .= '&sortby=' . urlencode($_GET['sortby']); //add whatever is currently in the GET sortby to the end of the url string
	   }
		
		
		$this->conn = $connection;
		$this->sql = $sql;
		$this->rows_per_page = (int)$rows_per_page;
		if (intval($links_per_page ) > 0) {
			$this->links_per_page = (int)$links_per_page;
		} else {
			$this->links_per_page = 5;
		}
		$this->append = $append;
		$this->php_self = htmlspecialchars($beginning_url);
		if (isset($_GET['page'] )) {
			$this->page = intval($_GET['page'] );
		}
	}
	
	/**
	 * Executes the SQL query and initializes internal variables
	 *
	 * @access public
	 * @return resource
	 */
	function paginate() {
		//Check for valid mysql connection
		if (! $this->conn || ! is_resource($this->conn )) {
			if ($this->debug)
				echo "MySQL connection missing<br />";
			return false;
		}
		
		//Find total number of rows
		$all_rs = @mysql_query($this->sql );
		if (! $all_rs) {
			if ($this->debug)
				echo "SQL query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
			return false;
		}
		$this->total_rows = mysql_num_rows($all_rs );
		@mysql_close($all_rs );
		
		/*//Return FALSE if no rows found
		if ($this->total_rows == 0) {
			if ($this->debug)
				echo "Query returned zero rows.";
			return FALSE;
		}*/
		
		//Max number of pages
		$this->max_pages = ceil($this->total_rows / $this->rows_per_page );
		if ($this->links_per_page > $this->max_pages) {
			$this->links_per_page = $this->max_pages;
		}
		
		//Check the page value just in case someone is trying to input an aribitrary value
		if ($this->page > $this->max_pages || $this->page <= 0) {
			$this->page = 1;
		}
		
		//Calculate Offset
		$this->offset = $this->rows_per_page * ($this->page - 1);
		
		//Fetch the required result set
		
		
		$rs = @mysql_query($this->sql . " LIMIT {$this->offset}, {$this->rows_per_page}" );
		if (! $rs) {
			if ($this->debug)
				echo "Pagination query failed. Check your query.<br /><br />Error Returned: " . mysql_error();
			return false;
		}
		return $rs;
	}
	
	
	//$curr_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
	/**
	 * Display the link to the first page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'First'
	 * @return string
	 */
	function renderFirst($tag = 'First') {
		//if ($this->total_rows == 0)
		//	return FALSE;
		
		if ($this->page == 1) {
			return "<a href=''>$tag</a>";
		} else if(isset($_GET['searchby'])){
			return '<a href="' . $this->php_self . '&page=1&' . $this->append . '">' . $tag . '</a> ';
		} else if(isset($_GET['sortby'])){
			return '<a href="' . $this->php_self . '&page=1&' . $this->append . '">' . $tag . '</a> ';
		} else {
			return '<a href="' . $this->php_self . '?page=1&' . $this->append . '">' . $tag . '</a> ';
		}
	}
	
	/**
	 * Display the link to the last page
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to 'Last'
	 * @return string
	 */
	function renderLast($tag = 'Last') {
		//if ($this->total_rows == 0)
		//	return FALSE;
		
		if ($this->page == $this->max_pages) {
			return "<a href=''>$tag</a>";
		} else if(isset($_GET['searchby'])){
			return ' <a href="' . $this->php_self . '&page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
		} else if(isset($_GET['sortby'])){
			return ' <a href="' . $this->php_self . '&page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
		} else {
			return ' <a href="' . $this->php_self . '?page=' . $this->max_pages . '&' . $this->append . '">' . $tag . '</a>';
		}
	}
	
	/**
	 * Display the next link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '>>'
	 * @return string
	 */
	function renderNext($tag = '&gt;&gt;') {
		//if ($this->total_rows == 0)
		//	return FALSE;
		
		if($this->page < $this->max_pages && isset($_GET['searchby'])){
			return '<a href="' . $this->php_self . '&page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else if($this->page < $this->max_pages && isset($_GET['sortby'])){
			return '<a href="' . $this->php_self . '&page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else if ($this->page < $this->max_pages) {
			return '<a href="' . $this->php_self . '?page=' . ($this->page + 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else {
			return "<a href=''>$tag</a>";
		}
	}
	
	/**
	 * Display the previous link
	 *
	 * @access public
	 * @param string $tag Text string to be displayed as the link. Defaults to '<<'
	 * @return string
	 */
	function renderPrev($tag = '&lt;&lt;') {
		//if ($this->total_rows == 0)
		//	return FALSE;
		
		if($this->page > 1 && isset($_GET['searchby'])){
			return ' <a href="' . $this->php_self . '&page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else if($this->page > 1 && isset($_GET['sortby'])){
			return ' <a href="' . $this->php_self . '&page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else if ($this->page > 1) {
			return ' <a href="' . $this->php_self . '?page=' . ($this->page - 1) . '&' . $this->append . '">' . $tag . '</a>';
		} else {
			return "<a href=''>$tag</a>";
		}
	}
	
	/**
	 * Display the page links
	 *
	 * @access public
	 * @return string
	 */
	function renderNav($prefix = '<span class="page_link"><span class="page_number">', $suffix = '</span></span>') {
		//if ($this->total_rows == 0)
		//	return FALSE;
		
		$nonactive_prefix = '<span id="nonactive_pag_link">';
		
		$batch = ceil($this->page / $this->links_per_page );
		$end = $batch * $this->links_per_page;
		if ($end == $this->page) {
			//$end = $end + $this->links_per_page - 1;
		//$end = $end + ceil($this->links_per_page/2);
		}
		if ($end > $this->max_pages) {
			$end = $this->max_pages;
		}
		$start = $end - $this->links_per_page + 1;
		$links = '';
		
		for($i = $start; $i <= $end; $i ++) {
			if ($i == $this->page) {
				$links .= $prefix . " $i " . $suffix;
			} else if(isset($_GET['searchby'])) {
				$links .= ' ' . $nonactive_prefix . '<a href="' . $this->php_self . '&page=' . $i . '&' . $this->append . '"><span class="page_number">' . $i . '</span></a></span>';
			} else if(isset($_GET['sortby'])) {
				$links .= ' ' . $nonactive_prefix . '<a href="' . $this->php_self . '&page=' . $i . '&' . $this->append . '"><span class="page_number">' . $i . '</span></a></span>';
			} else {
				$links .= ' ' . $nonactive_prefix . '<a href="' . $this->php_self . '?page=' . $i . '&' . $this->append . '"><span class="page_number">' . $i . '</span></a></span>';
			} 
		}
		
		return '<div id="page_buttons">' . $links . '</div>';
	}
	
	/**
	 * Display full pagination navigation
	 *
	 * @access public
	 * @return string
	 */
	function renderFullNav() {
		return $this->renderFirst() . '&nbsp;' . $this->renderPrev() . '&nbsp;' . $this->renderNav() . '&nbsp;' . $this->renderNext() . '&nbsp;' . $this->renderLast();
	}
	
	/**
	 * Set debug mode
	 *
	 * @access public
	 * @param bool $debug Set to TRUE to enable debug messages
	 * @return void
	 */
	function setDebug($debug) {
		$this->debug = $debug;
	}
}
?>
