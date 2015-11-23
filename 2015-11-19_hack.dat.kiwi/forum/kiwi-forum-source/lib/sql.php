<?php

function sql($Query)
{
	global $db;
	$DB=$db;
	$args = func_get_args ();
	if (count ( $args ) == 1)
	{
		$result = $DB->query ( $Query );
		if ($result)
		{
			if ($result->rowCount ())
				return $result->fetchAll ( PDO::FETCH_ASSOC );
		}
		else
		{
			$Error = $DB->errorInfo ();
			trigger_error ( "Unable to execute query: {$Query}, reason: {$Error[2]}" );
		}
		return null;
	}
	else
	{
		if (! $stmt = $DB->prepare ( $Query ))
		{
			$Error = $DB->errorInfo ();
			trigger_error ( "Unable to prepare statement: {$Query}, reason: {$Error[2]}" );
		}
		array_shift ( $args ); // remove $Query from args
		$i = 0;
		foreach ( $args as &$v )
			$stmt->bindValue ( ++ $i, $v );
		$stmt->execute ();
		
		$type = substr ( trim ( strtoupper ( $Query ) ), 0, 6 );
		if ($type == "INSERT")
		{
			$res = $DB->lastInsertId ();
			if ($res == 0 )
				return $stmt->rowCount();
			return $res;
		}
		elseif ($type == "DELETE" or $type == "UPDATE" or $type == "REPLAC")
			return $stmt->rowCount ();
		elseif ($type == "SELECT")
			return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
}
