<?php 

if(! function_exists('helloWorld'))
{
	function helloWorld($name = 'John Doe')
	{
		return 'Hi ' . $name;
	}
}

if(! function_exists('generateEmployeeId'))
{
	function generateEmployeeId()
	{
		return strtoupper(
			\Illuminate\Support\Str::random(10)
		);
	}
}