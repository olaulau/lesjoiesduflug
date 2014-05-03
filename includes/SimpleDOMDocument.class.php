<?php

class SimpleDOMDocument {
	
	/**
	 * 
	 * @var DOMNode
	 */
	private $node;
	
	
	/**
	 * 
	 * @param DOMNode $node
	 */
	public function __construct($node){
		$this->node = $node;
	}
	
	/**
	 * 
	 * @param String $xmlString
	 * @return SimpleDOMDocument
	 */
	public static function fromXmlString($xmlString) {
		$dom = new DOMDocument();
		$dom->loadXML($xmlString);
		$res = new SimpleDOMDocument($dom);
		return $res;
	}
	
	
	/**
	 * 
	 * @return SimpleDOMDocument
	 */
	public function getFirstChild() {
		$node = $this->node->childNodes->item(0);
		$res = new SimpleDOMDocument($node);
		return $res;
	}
	
	/**
	 * 
	 * @param String $type
	 * @return multitype:SimpleDOMDocument
	 */
	public function getChildrenOfType($type) {
		$res = array();
		foreach($this->node->childNodes as $item)
		{
			/* @var $item DOMNode */
			// 	print_r($item);
			if($item->nodeName == $type)
			{
				$res[] = new SimpleDOMDocument($item);
			}
		}
		return $res;
	}
	
	/**
	 * 
	 * @param String $type
	 */
	public function getFirstChildOfType($type) {
		$items = $this->getChildrenOfType($type);
		return $items[0];
	}
	
	
	/**
	 * 
	 * @return String
	 */
	public function getValue() {
		return $this->node->nodeValue;
	}
	
	/**
	 *
	 * @param String $value
	 */
	public function setValue($value) {
		$this->node->nodeValue = $value;
	}
	
	
	/**
	 * 
	 */
	public function delete() {
		$this->node->parentNode->removeChild($this->node);
	}
	
	/**
	 * 
	 * @return String
	 */
	public function toXmlString() {
		if($this->node instanceof DOMDocument) {
			return $this->node->saveXML();
		}
		elseif($this->node instanceof DOMNode) {
			$tmp = new DOMDocument();
			$tmp->importNode($this->node->cloneNode());
			return $tmp->saveXML();
		}
		else {
			echo "else";
		}
	}
	
	
	
}