<?php

class DBUtil extends Fuel\Core\DBUtil
{

	protected static function process_fields($fields, $prefix = '')
	{
		$sql_fields = array();

		foreach ($fields as $field => $attr)
		{
			$sql = "\n\t".$prefix;
			$attr = array_change_key_case($attr, CASE_UPPER);

			$sql .= \DB::quote_identifier($field);
			$sql .= array_key_exists('NAME', $attr) ? ' '.\DB::quote_identifier($attr['NAME']).' ' : '';
			$sql .= array_key_exists('TYPE', $attr) ? ' '.$attr['TYPE'] : '';
			$sql .= array_key_exists('CONSTRAINT', $attr) ? '('.$attr['CONSTRAINT'].')' : '';
			$sql .= array_key_exists('CHARSET', $attr) ? static::process_charset($attr['CHARSET']) : '';

			if (array_key_exists('UNSIGNED', $attr) and $attr['UNSIGNED'] === true)
			{
				$sql .= ' UNSIGNED';
			}

			if(array_key_exists('DEFAULT', $attr))
			{
				$sql .= ' DEFAULT '.(($attr['DEFAULT'] instanceof \Database_Expression) ? $attr['DEFAULT']  : \DB::escape($attr['DEFAULT']));
			}

			if(array_key_exists('NULL', $attr) and $attr['NULL'] === true)
			{
				$sql .= ' NULL';
			}
			else
			{
				$sql .= ' NOT NULL';
			}

			if (array_key_exists('AUTO_INCREMENT', $attr) and $attr['AUTO_INCREMENT'] === true)
			{
				$sql .= ' AUTO_INCREMENT';
			}

			if (array_key_exists('COMMENT', $attr))
			{
				$sql .= ' COMMENT '.\DB::escape($attr['COMMENT']);
			}

			if (array_key_exists('FIRST', $attr) and $attr['FIRST'] === true)
			{
				$sql .= ' FIRST';
			}
			elseif (array_key_exists('AFTER', $attr) and strval($attr['AFTER']))
			{
				$sql .= ' AFTER '.\DB::quote_identifier($attr['AFTER']);
			}

			$sql_fields[] = $sql;
		}

		return \implode(',', $sql_fields);
	}

}