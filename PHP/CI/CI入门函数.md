public function waker(){
          $sql = "select * from user_v2 limit 10";
          $query = $this->db->query($sql);
          //var_dump($query->result());//结果集,对象形式
          //var_dump($query->result_array());//结果集数组形式
          //var_dump($query->row());//单结果,对象
          //var_dump($query->row_array());//单结果,数组
          /*1.插入
          $sql = "insert into user_v2 (id,phone) values(null,'13800000005')";
          $this->db->query($sql);
          echo $this->db->affected_rows();
          */
          /*2.查询构造器
          $query = $this->db->get('user_v2');
          //var_dump($query); //对象
          //var_dump($query->result()); //object
          //使用查询构造器插入数据
          $data = array(
          	'phone'=>'11011011011',
            'email'=>'@qq.com',
          );
          $this->db->insert('user_v2',$data);          
          echo $this->db->insert_id();
          */
          /*3.简化查询
          $sql1 = "select * from user_v2 where id=0";
          $sql2 = "insert into user_v2 (id,phone) values (null,'11011011002')";
          //var_dump($this->db->simple_query($sql));
          if($this->db->simple_query($sql1)){ //查询成功就行,不管是否有数据
          	echo 'yes';
          }else{
          	echo 'no';
          }
          //
          if($this->db->simple_query($sql2)){
          	echo 'yes2';
          }else{
          	echo 'no2';
          }
          */
          /*4查询绑定
          $sql = "select * from push_talent where resume_status in (1,2,3,4) and resume_id = ?";
          $data = array(array(1,2,3,4),'887070');//ci 2.0不支持
          //$data[1] =  '887070';
          $query= $this->db->query($sql,$data );
          var_dump($query->result_array());
          */
          /*5
          $row1 = $query->first_row('array');
          $row2 = $query->last_row('array');
          $row3 = $query->next_row('array');
          $row4 = $query->previous_row('array');
          var_dump($row2);
          */
          /*6.查询结果的行数
          $query = $this->db->query('SELECT * FROM user_v2');
          echo $query->num_rows();
          */
          /*7.查询辅助函数
           * $this->db->insert_id() 新插入行的id
           * $this->db->affected_rows() insert,update等,返回受影响的行数
           * $this->db->last_query(); 上一次执行的查询语句
           * $this->db->insert_string() 相比insert更安全
           * $this->db->update_string()
           */
          //8.
          //$this->db->get();//一个表的所有数据
          //$query = $this->db->get('user_v2',10,1);//第二条数据开始,取10个
          //var_dump($query->result_array());
          //$query = $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
          //$query = $this->db->get_where('push_talent', array('resume_status' => 4), 10, 0);
          //var_dump($query->result_array());
          //$this->db->select('id,phone,nickname');
          //$query = $this->db->get('user_v2');
          //var_dump($query->result_array());
          //$this->db->select_max('age');//最大字段
          //$this->db->select_min('age');//最小字段
          ///$this->db->select_avg();
          //$this->db->select_sum();
          //
          //$this->db->select('*');
          //$this->db->get('push_talent');
          //$this->db->join('user_v2',' user_v2.id = push_talent.user_id');ci2.0不支持
          //$query = $this->db->get();
          /*9
          $arr = array('resume_status >'=>2,'favorite'=>1);
          //$where = "resume_status>'2' and favorite='1' ";//手工编写
          $this->db->where($arr);
          
          $this->db->select('*');
          $this->db->or_where('id < ',10); //或者
          $query = $this->db->get('push_talent');
          var_dump($query->result_array());exit;
          */
          /*10,
          $arr = array(1,2);
          $this->db->where_in('resume_status',$arr);
          $this->db->or_where_in('resume_status',array(3,4));
          $this->db->where_not_in('resume_status',array(5,6));
          $this->db->or_where_not_in('resume_status',array(7,8));
          $query = $this->db->get('push_talent');
          var_dump($query->result_array());
          */
           /*模糊搜索*/
          $arr = array('phone'=>'8','email'=>'com');
          $this->db->like($arr);
          $this->db->group_by(array('phone','email'));
          $this->db->order_by('phone','desc');
          $query = $this->db->get('talent',10);
          //var_dump($query->result_array());
          //
         // $this->db->insert('mytable', $data);
          //$this->db->replace('table', $data);
          
          //删除
          $tables = array('table1', 'table2', 'table3');
          $this->db->where('id', '5');
          $this->db->delete($tables);