<?php
/**
 * OnePica
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to codemaster@onepica.com so we can send you a copy immediately.
 *
 * @category  OnePica
 * @package   OnePica_AvaTax16
 * @copyright Copyright (c) 2016 One Pica, Inc. (http://www.onepica.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace OnePica\AvaTax16\IO;

/**
 * Class \OnePica\AvaTax16\IO\CaseInsensitiveArray
 */
class CaseInsensitiveArray implements \ArrayAccess, \Countable, \Iterator
{
    /**
     * Container
     *
     * @var array
     */
    protected $container = array();

    /**
     * Offset Set
     *
     * @param  string $offset
     * @param  mixed $value
     * @return $this
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->container[] = $value;
        } else {
            $index = array_search(strtolower($offset), array_keys(array_change_key_case($this->container, CASE_LOWER)));
            if (!($index === false)) {
                $keys = array_keys($this->container);
                unset($this->container[$keys[$index]]);
            }
            $this->container[$offset] = $value;
        }
    }

    /**
     * Offset Exists
     *
     * @param  string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists(strtolower($offset), array_change_key_case($this->container, CASE_LOWER));
    }

    /**
     * Offset Unset
     *
     * @param  string $offset
     * @return $this
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Offset Get
     *
     * @param  string $offset
     * @return object|null
     */
    public function offsetGet($offset)
    {
        $index = array_search(strtolower($offset), array_keys(array_change_key_case($this->container, CASE_LOWER)));
        if ($index === false) {
            return null;
        }

        $values = array_values($this->container);
        return $values[$index];
    }

    /**
     * Count
     *
     * @return int
     */
    public function count()
    {
        return count($this->container);
    }

    /**
     * Current
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->container);
    }

    /**
     * Next
     *
     * @return mixed
     */
    public function next()
    {
        return next($this->container);
    }

    /**
     * Key
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->container);
    }

    /**
     * Valid
     *
     * @return bool
     */
    public function valid()
    {
        return !($this->current() === false);
    }

    /**
     * Rewind
     *
     * @return mixed
     */
    public function rewind()
    {
        reset($this->container);
    }
}
