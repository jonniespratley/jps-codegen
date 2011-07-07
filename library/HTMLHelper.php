<?php

/**
 * I am a html helper class.
 */
class HTMLHelper
{
	public function __construct() {
	}

	/**
	 * I create a un-ordered list
	 * @return
	 * @param object $id
	 * @param object $class[optional]
	 * @param object $items[optional]
	 */
	public function doUL($id, $class = null, $items = null)
	{
		$ul = '<ul id="'.$id.'class="'.$class.'">';

		foreach ($items as $item)
		{
			$ul .= '<li>'.$item.'</li>';
		}
		$ul .= '</ul>';

		return $ul;
	}

	/**
	 *
	 * @return
	 * @param object $id
	 * @param object $class[optional]
	 * @param object $items[optional]
	 */
	public function doOL($id, $class = null, $items = null)
	{
		$ul = '<ol id="'.$id.'" class="'.$class.'">';

		foreach ($items as $item)
		{
			$ul .= '<li>'.$item.'</li>';
		}
		$ul .= '</ol>';

		return $ul;
	}

	/**
	 *
	 * @return
	 * @param object $id
	 * @param object $class[optional]
	 * @param object $items[optional]
	 */
	public function doTabs($id, $class = null, $items = null)
	{
		$links = array ();
		foreach ($items as $title=>$link)
		{

			$link = '<a href="'.$link.'" title="'.$title.'">'.$title.'</a>';

			array_push($links, $link);
		}

		return $this->doUL($id, $class, $links);
	}

	/**
	 * <input name="txt_application" type="text" id="txt_application" value="CodeGenTest" class="medium"/>
	 *	<label class="description" for="txt_namespace">
	 *		Application Namespace:
	 *	</label>
	 */
	 
	 /**
	 * I create a options form
	 *
	 * @param array $options Array with key value pairs, keys should be ( name, type, value, class )
	 */
	public function doOptions($options)
	{
		$item = '';
		foreach ($options as $option)
		{
			$item .= '<p>'.$this->doLabel($option['name'], ucfirst($option['label']));

			if ($option['type'] == 'select')
			{
				$item .= $this->doSelect($option['name'], $option['options'], $option['class']);
			}
			else
			{
				$item .= $this->doInput($option['type'], $option['name'], $option['value'], $option['class']);
			}
			$item .= '</p>';
		}

		return $item;
	}

	/**
	 *
	 * @return
	 * @param object $type
	 * @param object $name
	 * @param object $value
	 * @param object $class
	 * @param object $other[optional]
	 */
	public function doInput($type, $name, $value, $class, $other = null)
	{
		$input = '
		<input name="'.$name.'" type="'.$type.'" id="'.$name.'" value="'.$value.'" ';

		if ($other)
		{
			foreach ($other as $att=>$value)
			{
				$input .= $att.' ="'.$value.'" ';
			}
		}
		$input .= '/>';
		return $input;
	}

	/**
	 *
	 * @return
	 * @param object $for
	 * @param object $name
	 */
	public function doLabel($for, $name)
	{
		$label = '
		<label for="'.$for.'">'.ucfirst($name).' </label>';

		return $label;
	}

	/**
	 *
	 * @return
	 * @param object $name
	 * @param object $value
	 * @param object $class
	 */
	public function doButton($title, $name, $value, $class = null)
	{
		$button = '<button name="'.$name.'" class="'.$class.'" value="'.$value.'">'.$title.'</button>';

		return $button;
	}

	/**
	 *
	 * @return
	 * @param object $name
	 * @param object $options
	 * @param object $class
	 */
	public function doSelect($name, $options = array(), $class = null)
	{
		$select = '
		<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
		$selectOptions = '';

		foreach ( $options as $value => $label)
		{
			$selectOptions .= '
			<option value="'.$value.'">'.$label.'</option>';
		}
		$select .= $selectOptions.'</select>';

		return $select;

	}

	/**
	 * I wrap something in a <div> tag
	 *
	 * <code>
	 *
	 * <div id="ID" class="CLASS">WRAP</div>
	 *
	 * </code>
	 *
	 * @param [string] $id
	 * @param [string] $class
	 * @param [string] $wrap
	 */
	public function doDiv($id, $class = null, $wrap = null)
	{
		$div = '<div id="'.$id.'">'.$wrap.'</div>';

		return $div;
	}

}

?>
