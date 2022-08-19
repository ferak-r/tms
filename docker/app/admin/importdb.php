<?php
require_once("lib/site.module.php");

function remove_comments(&$output)
{
    $lines = explode("\n",  $output);
    $output = "";

    // try to keep mem. use down
    $linecount = count($lines);
    $in_comment = false;
    for($i = 0; $i < $linecount; $i++){
        if( preg_match("/^\/\*/",  preg_quote($lines[$i])) ){
            $in_comment = true;
        }
        if( !$in_comment ){
            $output .= $lines[$i] . "\n";
        }
        if( preg_match("/\*\/$/",  preg_quote($lines[$i])) ){
            $in_comment = false;
        }
    }
    unset($lines);
    return $output;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
    $lines = explode("\n",  $sql);
    
    // try to keep mem. use down
    $sql = "";
    
    $linecount = count($lines);
    $output = "";
    for ($i = 0; $i < $linecount; $i++){
        if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0)){
            if ( $lines[$i] and $lines[$i][0] != "#" and $lines[$i][0] != "-" and $lines[$i][0] != "\r" and $lines[$i][0] != "\n" ){
                $output .= $lines[$i] . "\n";
            }
/*
            else
            {
                $output .= "\n";
            }
*/
            // Trading a bit of speed for lower mem. use here.
            $lines[$i] = "";
        }
    }
    return $output;
}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql,  $delimiter)
{
    // Split up our string into "possible" SQL statements.
    $tokens = explode($delimiter,  $sql);

    // try to save mem.
    $sql = "";
    $output = array();
    
    // we don't actually care about the matches preg gives us.
    $matches = array();
    
    // this is faster than calling count($oktens) every time thru the loop.
    $token_count = count($tokens);
    for ($i = 0; $i < $token_count; $i++){
        // Don't wanna add an empty string as the last thing in the array.
        if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0))){
            // This is the total number of single quotes in the token.
            $total_quotes = preg_match_all("/'/",  $tokens[$i],  $matches);
            // Counts single quotes that are preceded by an odd number of backslashes,
            // which means they're escaped quotes.
            $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",  $tokens[$i],  $matches);
            $unescaped_quotes = $total_quotes - $escaped_quotes;
            
            // If the number of unescaped quotes is even,  then the delimiter did NOT occur inside a string literal.
            if (($unescaped_quotes % 2) == 0){
                // It's a complete sql statement.
                $output[] = $tokens[$i];
                // save memory.
                $tokens[$i] = "";
            }else{
                // incomplete sql statement. keep adding tokens until we have a complete one.
                // $temp will hold what we have so far.
                $temp = $tokens[$i] . $delimiter;
                // save memory..
                $tokens[$i] = "";
                
                // Do we have a complete statement yet?
                $complete_stmt = false;
                
                for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++){
                    // This is the total number of single quotes in the token.
                    $total_quotes = preg_match_all("/'/",  $tokens[$j],  $matches);
                    // Counts single quotes that are preceded by an odd number of backslashes,
                    // which means they're escaped quotes.
                    $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",  $tokens[$j],  $matches);
            
                    $unescaped_quotes = $total_quotes - $escaped_quotes;
                    
                    if (($unescaped_quotes % 2) == 1){
                        // odd number of unescaped quotes. In combination with the previous incomplete
                        // statement(s),  we now have a complete statement. (2 odds always make an even)
                        $output[] = $temp . $tokens[$j];

                        // save memory.
                        $tokens[$j] = "";
                        $temp = "";
                        
                        // exit the loop.
                        $complete_stmt = true;
                        // make sure the outer loop continues at the right point.
                        $i = $j;
                    }else{
                        // even number of unescaped quotes. We still don't have a complete statement.
                        // (1 odd and 1 even always make an odd)
                        $temp .= $tokens[$j] . $delimiter;
                        // save memory.
                        $tokens[$j] = "";
                    }
                } // for..
            } // else
        }
    }
    return $output;
}

switch($cmd){
	case 'import':
		//upload sql file
		$sql = file_get_contents($_FILES['importfile']['tmp_name']);
		unlink($_FILES['importfile']['tmp_name']);		  
		preg_match_all("/((([^;']*)|('([^'\\\\]*|(\\\\.))*'))*;)/", $sql, $ar);
		$db->autoCommit(false);
		foreach($ar[0] as $key => $val){
			$val = trim($val); 
			//echo $res[$key], "\n<br><br><br><br>\n";
			$res = $db->query($val);
		}	
		$db->commit();
		$db->autoCommit(true);
		break;
}
/*$sql = remove_comments(remove_remarks(file_get_contents('karan.sql')));

preg_match_all("/([^;']*('([^']*|\\')*')*)*;/", $sql, $ar);	
foreach($ar[0] as $key => $val){
	$res[$key] = trim($val); 
	echo $res[$key], "\n<br><br><br><br>\n";
	//$res = $db->query($res[$key]);
}
*/
$tplModule = "importdb.tpl";
//###samarty
trace($smarty->_tpl_vars);
?>