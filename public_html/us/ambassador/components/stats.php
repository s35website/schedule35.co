<?php 
	/* Pull sheet music stats */
	$trendrow = $item->trendingProducts();
	putenv("TZ=America/Toronto");
	date_default_timezone_set("America/Toronto");
	$itemsrow = $item->getProducts(); 
	
	$payout = $urow->payout;

	$curr_year = date(Y);
	$curr_month = date(n);
	$curr_day = date(j);
	
	// Daily Revenue
	$todaysRevenue = $analytics->dayRevenue($curr_year, $curr_month, $curr_day, $urow->invite_code)->total;
	$yesterdaysRevenue = $analytics->dayRevenue($curr_year, $curr_month, $curr_day - 1, $urow->invite_code)->total;
	// Calculate revenue difference in percentage
	$dailyRevDifference = $todaysRevenue - $yesterdaysRevenue;
	if ($yesterdaysRevenue == 0) {
		$dailyRevDifference = 0;
	}
	else {
		$dailyRevDifference = abs($dailyRevDifference / $yesterdaysRevenue) * 100;
	}
	
	$dailyRevDifference = round($dailyRevDifference, 1);
	
	// Monthly Revenue
	$monthRevenue = $analytics->monthRevenue($curr_year, $curr_month, $urow->invite_code)->total;
	$lastMonthRevenue = $analytics->monthRevenue($curr_year, $curr_month - 1, $urow->invite_code)->total;
	// Calculate revenue difference in percentage
	$monthlyRevDifference = abs($monthRevenue - $lastMonthRevenue);
	if ($lastMonthRevenue == 0) {
		$monthlyRevDifference = 0;
	}
	else {
		$monthlyRevDifference = abs($monthlyRevDifference / $lastMonthRevenue) * 100;
	}
	
	$monthlyRevDifference = round($monthlyRevDifference, 1);
	
	// Active Users
	$activeUsers = countEntriesToday(Users::uTable, "DATE(created)");
	$activeUsersPrevious = countEntriesYesterday(Users::uTable, "DATE(created)");
	$activeUsersTotal = countEntries(Users::uTable, "active", "y");
	
	//Calculate total sales
	$monthSales = $analytics->monthSales($curr_year, $curr_month, $urow->invite_code)->total;
	
	$countSales = $analytics->countSales($urow->invite_code);
	
	$transrow = $item->getPayments();
	$todaysSales = 0;
	$salesChange = 0;
	
	/* sales change percentage */
	if ($transrow) {
		foreach ($transrow as $row) {
			if (date('Ymd', strtotime($row->created)) == date('Ymd')) {
				$todaysSales = $row->price + $row->tax + $todaysSales;
			}
			if (date('Ymd', strtotime($row->created)) == date('Ymd', strtotime("yesterday"))) {
				$yesterdaysSales = $row->price + $row->tax + $yesterdaysSales;
			}
		}
		if ($yesterdaysSales > 0) {
			if ($yesterdaysSales == 0) {
				$salesChange = 0;
			}
			else {
				$salesChange = round(($todaysSales - $yesterdaysSales) / $yesterdaysSales * 100, 2);
			}
			
		}
		
	}
	
		
	
	
	
	$pageViews = 0;
	$uniqueViews = 0;
	
	function getPageViews()
	{   
	    $statsquery = Registry::get("Database")->fetch_all("SELECT * FROM stats");
	    
	    $sql = Registry::get("Database")->query("SELECT id FROM stats");
	    $statsquerynum = Registry::get("Database")->numrows($sql);
	    
	    $i = 0;
	    foreach ($statsquery as $sRow) {
	    	$xView = "x: " . $sRow->id;
	    	$yView = "y: " . $sRow->hits;
	    	$tView .= "{ " . $xView . ", " . $yView . " }";
	    	$i++;
	    	if ($i < $statsquerynum) {
	    		$tView .= ", ";
	    	}
	    }
	    
	    return $tView;
	}
	
	
	function getUniqueViews()
	{   
	    $statsquery = Registry::get("Database")->fetch_all("SELECT * FROM stats");
	    
	    $sql = Registry::get("Database")->query("SELECT id FROM stats");
	    $statsquerynum = Registry::get("Database")->numrows($sql);
	    
	    $i = 0;
	    foreach ($statsquery as $sRow) {
	    	$xView = "x: " . $sRow->id;
	    	$yView = "y: " . $sRow->uhits;
	    	$tView .= "{ " . $xView . ", " . $yView . " }";
	    	$i++;
	    	if ($i < $statsquerynum) {
	    		$tView .= ", ";
	    	}
	    }
	    
	    return $tView;
	}
	
	function getTotalViews()
	{   
	    $statsquery = Registry::get("Database")->fetch_all("SELECT * FROM stats");
	    
	    $sql = Registry::get("Database")->query("SELECT id FROM stats");
	    $statsquerynum = Registry::get("Database")->numrows($sql);
	    
	    $i = 0;
	    foreach ($statsquery as $sRow) {
	    	$xView = "x: " . $sRow->id;
	    	$yView = "y: " . ($sRow->uhits + $sRow->hits);
	    	$tView .= "{ " . $xView . ", " . $yView . " }";
	    	$i++;
	    	if ($i < $statsquerynum) {
	    		$tView .= ", ";
	    	}
	    }
	    
	    return $tView;
	}
	
	function convertMonth($monthNum) {
		return date('F', strtotime($monthNum));
	}
	
?>