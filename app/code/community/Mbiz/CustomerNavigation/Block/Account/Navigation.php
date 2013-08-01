<?php
/**
 * This file is part of Mbiz_CustomerNavigation for Magento.
 *
 * @license All rights reserved
 * @author Jacques Bodin-Hullin <j.bodinhullin@monsieurbiz.com>
 * @category Mbiz
 * @package Mbiz_CustomerNavigation
 * @copyright Copyright (c) 2013 Monsieur Biz (http://monsieurbiz.com)
 */

/**
 * Account_Navigation Block
 * @package Mbiz_CustomerNavigation
 */
class Mbiz_CustomerNavigation_Block_Account_Navigation extends Mage_Customer_Block_Account_Navigation
{

// Monsieur Biz Tag NEW_CONST

    /**
     * Updated links
     * @access protected
     * @var array
     */
    protected $_updatedLinks = array();

    /**
     * Deleted links
     * @access protected
     * @var array
     */
    protected $_deletedLinks = array();

// Monsieur Biz Tag NEW_VAR

    /**
     * Delete navigation link
     * @access public
     * @return Mbiz_CustomerNavigation_Block_Account_Navigation
     */
    public function deleteLink($name)
    {
        // If we have more than one link, delete all of them
        if (is_array($name)) {
            foreach ($name as $n) {
                $this->deleteLink($n);
            }
        } else {
            // Delete the link if exists
            $this->_deletedLinks[$name] = true;
        }

        return $this;
    }

    /**
     * Update navigation link
     * @access public
     * @return Mbiz_CustomerNavigation_Block_Account_Navigation
     */
    public function updateLink($name, $path, $label, $urlParams = array())
    {
        $this->_updatedLinks[$name] = new Varien_Object(array(
            'name'  => $name,
            'path'  => $path,
            'label' => $label,
            'url'   => $this->getUrl($path, $urlParams),
        ));
        return $this;
    }

    /**
     * Returns all links
     * @access public
     * @return array
     */
    public function getLinks()
    {
        $links = array();

        foreach ($this->_links as $link) {
            $name = $link->getName();
            if (!isset($this->_deletedLinks[$name])) {
                if (isset($this->_updatedLinks[$name])) {
                    $links[$name] = $this->_updatedLinks[$name];
                } else {
                    $links[$name] = $link;
                }
            }
        }

        return $links;
    }

// Monsieur Biz Tag NEW_METHOD

}