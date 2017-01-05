<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/21
 * Time: 15:08
 */

namespace Admin\Logic;


class MysqlDb implements DbMysqlInt
{
    /**
     * DB connect
     *
     * @access public
     *
     * @return resource connection link
     */
    public function connect()
    {
        // TODO: Implement connect() method.
    }

    /**
     * Disconnect from DB
     *
     * @access public
     *
     * @return viod
     */
    public function disconnect()
    {
        // TODO: Implement disconnect() method.
    }

    /**
     * Free result
     *
     * @access public
     * @param resource $result query resourse
     *
     * @return viod
     */
    public function free($result)
    {
        // TODO: Implement free() method.
    }

    /**
     * Execute simple query
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return resource|bool query result
     */
    public function query($sql, array $args = array())
    {
        //获取数据
        $args = func_get_args();
        //调用拼凑sql语句方法
        $sql = $this->_buildSql($args);
        //返回受影响的行数
        return M()->execute($sql);
    }

    /**
     * 添加商品分类操作，返回添加新分类的id
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false last insert id
     */
    public function insert($sql, array $args = array())
    {
        $args = func_get_args();
        //获取sql语句
        $sql = $args[0];
        //获取表名数据
        $tableName = $args[1];
        //替换sql语句
        $sql = str_replace('?T',$tableName,$sql);
        $params = $args[2];
        $tmp_sql = [];
        foreach($params as $field=>$value){
            $tmp_sql[] = $field . '="' . $value .'"';
        }
        $tmp_sql = implode(',',$tmp_sql);
        $sql = str_replace('?%',$tmp_sql,$sql);
        //执行s添加ql语句
        M()->execute($sql);
        //返回最后添加新分类的id
        return M()->getLastInsID();
    }

    /**
     * Update query method
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return int|false affected rows
     */
    public function update($sql, array $args = array())
    {
        echo __METHOD__ . '<br/>';
        dump(func_get_args());
        echo '<hr />';
    }

    /**
     * Get all query result rows as associated array
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAll($sql, array $args = array())
    {
        //获取数据
        $args = func_get_args();
        //调用拼凑sql语句方法
        $sql = $this->_buildSql($args);
        //执行sql语句 获取并返回结果集 二维数组
        return M()->query($sql);
    }

    /**
     * Get all query result rows as associated array with first field as row key
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array (two level array)
     */
    public function getAssoc($sql, array $args = array())
    {
        echo __METHOD__ . '<br/>';
        dump(func_get_args());
        echo '<hr />';
    }

    /**
     *返回第一行记录，关联数组的方式
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     */
    public function getRow($sql, array $args = array())
    {
       //获取数据
        $args = func_get_args();
        //调用拼凑sql语句方法
        $sql = $this->_buildSql($args);
        //执行sql语句
        $rst = M()->query($sql);
        //返回第一行数据
        return array_shift($rst);
    }

    /**
     * Get first column of query result
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array one level data array
     */
    public function getCol($sql, array $args = array())
    {
        echo __METHOD__ . '<br/>';
        dump(func_get_args());
        echo '<hr />';
    }

    /**
     * 获取第一行第一列的数据
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return string field value
     */
    public function getOne($sql, array $args = array())
    {
        //获取数据
        $args = func_get_args();
        //调用拼凑sql语句方法
        $sql = $this->_buildSql($args);
        //执行sql语句
        $rst = M()->query($sql);
        //获取第一行数据
        $row = array_shift($rst);
        //获取第一列数据
        $field = array_shift($row);
        return $field;
    }

    /**
     * 拼凑sql语句
     * @param array $args
     * @return string
     */
    private function _buildSql(array $args){
        //获取sql结构
        $sql = array_shift($args);
        //通过占位分割sql语句
        $sql = preg_split('/\?[FNT]/',$sql);
        //删除sql数组中的多余元素
        array_pop($sql);
        //拼凑出完整的sql语句
        $tmpSql = '';
        foreach($sql as $key=>$value){
            $tmpSql .= $value.$args[$key];
        }
        return $tmpSql;
    }
}