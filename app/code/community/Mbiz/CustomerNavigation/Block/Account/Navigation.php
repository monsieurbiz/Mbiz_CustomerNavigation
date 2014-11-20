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
     * @var array
     */
    protected $_updatedLinks = [];

    /**
     * Deleted links
     * @var array
     */
    protected $_deletedLinks = [];

    /**
     * Order links
     * @var array
     */
    protected $_orders = [];

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
     * @param string $name Link's name
     * @param string $path Url path
     * @param string $label Frontend label
     * @param array $urlParams URL parameters. Default to empty array.
     * @return Mbiz_CustomerNavigation_Block_Account_Navigation
     */
    public function updateLink($name, $path, $label, $urlParams = array())
    {
        $this->_updatedLinks[$name] = new Varien_Object([
            'name'  => $name,
            'path'  => $path,
            'label' => $label,
            'url'   => (strpos($path, 'http') === 0) ? $path : $this->getUrl($path, $urlParams),
        ]);

        return $this;
    }

    /**
     * Set the order of a link
     * @param string $name Link's name to move
     * @param int $order The order integer : 1st <= $order <= last.
     * @return Mbiz_CustomerNavigation_Block_Account_Navigation
     */
    public function setLinkOrder($name, $order)
    {
        $this->_orders[$name] = (int) $order;
        return $this;
    }

    /**
     * Returns all links
     * @access public
     * @return array
     */
    public function getLinks()
    {
        $links = [];

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

        $this->_orderLinks($links);

        return $links;
    }

    /**
     * {@inheritdoc}
     * <p>The path can be an URL.</p>
     */
    public function addLink($name, $path, $label, $urlParams=array())
    {
        parent::addLink($name, $path, $label, $urlParams);

        if (strpos($path, 'http') === 0) {
            $this->_links[$name]['url'] = $path;
        }

        return $this;
    }

    /**
     * Reorder links
     * @param array $links Links to order
     */
    protected function _orderLinks(& $links)
    {
        $callback = function ($a, $b) {
            $aOrder = isset($this->_orders[$a['name']]) ? $this->_orders[$a['name']] : 0;
            $bOrder = isset($this->_orders[$b['name']]) ? $this->_orders[$b['name']] : 0;
            return $aOrder - $bOrder;
        };

        usort($links, $callback);
    }

    /**
     * {@inheritdoc}
     * <p>The path can be an URL.</p>
     */
    protected function _completePath($path)
    {
        if (strpos($path, 'http') === 0) {
            return $path;
        }

        return parent::_completePath($path);
    }

// Monsieur Biz Tag NEW_METHOD

}