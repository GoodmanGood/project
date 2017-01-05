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
        //��ȡ����
        $args = func_get_args();
        //����ƴ��sql��䷽��
        $sql = $this->_buildSql($args);
        //������Ӱ�������
        return M()->execute($sql);
    }

    /**
     * �����Ʒ�����������������·����id
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
        //��ȡsql���
        $sql = $args[0];
        //��ȡ��������
        $tableName = $args[1];
        //�滻sql���
        $sql = str_replace('?T',$tableName,$sql);
        $params = $args[2];
        $tmp_sql = [];
        foreach($params as $field=>$value){
            $tmp_sql[] = $field . '="' . $value .'"';
        }
        $tmp_sql = implode(',',$tmp_sql);
        $sql = str_replace('?%',$tmp_sql,$sql);
        //ִ��s���ql���
        M()->execute($sql);
        //�����������·����id
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
        //��ȡ����
        $args = func_get_args();
        //����ƴ��sql��䷽��
        $sql = $this->_buildSql($args);
        //ִ��sql��� ��ȡ�����ؽ���� ��ά����
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
     *���ص�һ�м�¼����������ķ�ʽ
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return array associated data array
     */
    public function getRow($sql, array $args = array())
    {
       //��ȡ����
        $args = func_get_args();
        //����ƴ��sql��䷽��
        $sql = $this->_buildSql($args);
        //ִ��sql���
        $rst = M()->query($sql);
        //���ص�һ������
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
     * ��ȡ��һ�е�һ�е�����
     *
     * @access public
     * @param string $sql SQL query
     * @param array $args query arguments
     *
     * @return string field value
     */
    public function getOne($sql, array $args = array())
    {
        //��ȡ����
        $args = func_get_args();
        //����ƴ��sql��䷽��
        $sql = $this->_buildSql($args);
        //ִ��sql���
        $rst = M()->query($sql);
        //��ȡ��һ������
        $row = array_shift($rst);
        //��ȡ��һ������
        $field = array_shift($row);
        return $field;
    }

    /**
     * ƴ��sql���
     * @param array $args
     * @return string
     */
    private function _buildSql(array $args){
        //��ȡsql�ṹ
        $sql = array_shift($args);
        //ͨ��ռλ�ָ�sql���
        $sql = preg_split('/\?[FNT]/',$sql);
        //ɾ��sql�����еĶ���Ԫ��
        array_pop($sql);
        //ƴ�ճ�������sql���
        $tmpSql = '';
        foreach($sql as $key=>$value){
            $tmpSql .= $value.$args[$key];
        }
        return $tmpSql;
    }
}