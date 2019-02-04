<?
class Array_Manipulasi{
	var $arr;
	function Array_Manipulasi($input)
	{
		$this->arr = $input;
	}
	
	function delete($hapus)
	{
	$index=0;
	for($c=0;$c<count($this->arr);$c++)
		{
			if($hapus!=$c)
			{
			$temp[$index]=$this->arr[$c];
			$index++;
			}
		}
	if(count($this->arr)<=1)
	{
		$temp = array();
	}
	return $temp;
	}
	
	function push($value)
	{
	$temp =  $this->arr;
	$temp[count($this->arr)] = $value;
	return $temp;
	}
	
	function pop()
	{
	$index=0;
	for($c=0;$c<(count($this->arr)-1);$c++)
		{
			$temp[$index]=$this->arr[$c];
			$index++;
		}
	if(count($this->arr)<=1)
	{
		$temp = array();
	}
	return $temp;
	}
	
	function insert($value, $index)
	{
	/*
	masih belum sabar yah
	*/
	}
	
	function update($value, $index)
	{
	/*
	masih belum sabar yah
	*/
	}
}
?>