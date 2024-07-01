<?php

class chatbotModel extends CI_model
{
 function getReply($chat)
 {
  $tanya = $this->db->escape_str($chat);
  $this->db->select('jawab');
  $this->db->like('tanya', $tanya);
  return $this->db->get('chatbot');
 }

 function getAllChat()
 {
  return $this->db->get('chatbot');
 }

 function addChat($id, $chat)
 {
  return $this->db->insert('chatbot', ['id' => $id, 'tanya' => $chat]);
 }
}
