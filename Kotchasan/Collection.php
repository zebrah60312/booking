<?php

/**
 * @filesource Kotchasan/Collection.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Kotchasan;

/**
 * Collection Class
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Collection implements \Countable, \IteratorAggregate, \ArrayAccess
{
    /**
     * ตัวแปรเก็บสมาชิกของคลาส
     *
     * @var array
     */
    private $datas = array();

    /**
     * Create new collection
     *
     * @param array $items สมาชิกเริ่มต้นของ Collection
     */
    public function __construct(array $items = array())
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * ลบข้อมูลทั้งหมด
     */
    public function clear()
    {
        $this->datas = array();
    }

    /**
     * คืนค่าจำนวนข้อมูลทั้งหมด
     *
     * @return int
     */
    public function count()
    {
        return count($this->datas);
    }

    /**
     * อ่านข้อมูลที่ $key ถ้าไม่พบคืนค่า $default
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->datas[$key] : $default;
    }

    /*   * **********************
     * IteratorAggregate interface
     * ************************* */

    /**
     * Retrieve an external iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->datas);
    }

    /**
     * ตรวจสอบว่ามีรายการ $key หรือไม่
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->datas);
    }

    /**
     * อ่านรายชื่อ keys
     * คืนค่าแอเรย์ของรายการ key ทั้งหมด
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->datas);
    }

    /*   * *****************
     * ArrayAccess interface
     * ********************* */

    /**
     * ตรวจสอบว่ามีรายการ $key หรือไม่
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * อ่านข้อมูลที่ $key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * กำหนดค่า $value ของ $key
     *
     * @param string $key
     * @param mixed  $value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * ลบรายการที่ $key
     *
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /**
     * ลบรายการที่ $key
     *
     * @param string $key
     */
    public function remove($key)
    {
        unset($this->datas[$key]);
    }

    /**
     * เพิ่มรายการใหม่ แทนที่รายการเดิม
     *
     * @param array $items array(array($key => $value), array($key => $value), ...)
     */
    public function replace(array $items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    /*   * ****************
     * Collection interface
     * ******************* */

    /**
     * กำหนดค่า $value ของ $key
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->datas[$key] = $value;
    }

    /**
     * คืนค่าข้อมูลทั้งหมดเป็น
     *
     * @return array
     */
    public function toArray()
    {
        return $this->datas;
    }
}
