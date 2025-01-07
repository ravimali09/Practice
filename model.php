<?php
class Model
{
    public $conn="";
    function __construct()
    {
        $this->conn= new mysqli('localhost', 'root', '', 'practice');
    }
    function select($table)
    {
        $sel= "select * from $table";
        $run= $this->conn->query($sel);

        while($fetch= $run->fetch_object())
        {
            $arr[]= $fetch;
        }
        return $arr;
    }
    function select_where($table, $arr)
    {
         $column_arr = array_keys($arr);
        $value_arr = array_values($arr);

        $sel = "SELECT * FROM $table WHERE 1=1";
        $i = 0;
        foreach ($arr as $w) {
            $sel .= " AND $column_arr[$i] = '$value_arr[$i]'";
            $i++;
        }
        $run = $this->conn->query($sel);
        return $run;
    }
    function insert($table, $arr)
    {
        $column_arr= array_keys($arr);
        $column= implode(",", $column_arr);

        $value_arr= array_values($arr);
        $value= implode("','", $value_arr);

        $sel= "insert into $table ($column) value ('$value')";
        $run = $this->conn->query($sel);
        return $run;
    }
    function update($tbl,$arr,$where)
	{
		$column_arr=array_keys($arr);
		$values_arr=array_values($arr);
		
		$upd="update $tbl set ";
		$j=0;
		$count=count($arr);
		foreach($arr as $w)
		{
			if($count==$j+1)
			{
				$upd.= "$column_arr[$j]='$values_arr[$j]'";
			}
			else
			{
				$upd.= "$column_arr[$j]='$values_arr[$j]',";
				$j++;
			}
		}
		$wcolumn_arr=array_keys($where);
		$wvalues_arr=array_values($where);
		$upd.=" where 1=1";
		$i=0;
		foreach($where as $w)
		{
			echo $upd.=" and $wcolumn_arr[$i]='$wvalues_arr[$i]'";
			$i++;
		}
		$run=$this->conn->query($upd); 
		return $run;
	}
    function delete_where($tbl,$arr)
{
	$column_arr=array_keys($arr);
	$values_arr=array_values($arr);
	
	$del="delete from $tbl where 1=1";  // 1=1 means query contnue
	$i=0;
	foreach($arr as $w)
	{
		echo $del.=" and $column_arr[$i]='$values_arr[$i]'";
		$i++;
	}
	$run=$this->conn->query($del);  // query run on db
	return $run;
}
}
$obj= new Model;
?>