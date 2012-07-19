<?php
    require_once(PW2_PATH . '/src/Monitor.php');
    require_once(PW2_PATH . '/src/Channel.php');
    #add phpmailer
    require_once(PW2_PATH . '/src/Mailer.php');

    class EmailChannel extends Channel
    {
        public function getSubjectFormat()
        {
            return $this->config['subject'];
        }

        public function getMessageFormat()
        {
            return $this->config['message'];
        }

        private function getSubject($monitor)
        {
            return sprintf($this->config['subject'], $monitor->getHostname(), $monitor->getPort(), $monitor->getAlias());
        }

        private function getMessage($monitor)
        {
            return sprintf($this->config['message'], $monitor->getHostname(), $monitor->getPort(), $monitor->getAlias());
        }

        public function getAddress()
        {
            return $this->config['address'];
        }

        public function doNotify($monitor)
        {   
            if(defined('MAIL_TYPE') && MAIL_TYPE=='client'){
                $result = Mailer::mail_client($this->config['address'], $this->getSubject($monitor), $this->getMessage($monitor));
                if(false === $result){
                    sleep(3);
                    Mailer::mail_client($this->config['address'], $this->getSubject($monitor), $this->getMessage($monitor));
                }
            }else{
                mail($this->config['address'], $this->getSubject($monitor), $this->getMessage($monitor));
            }
        }

        public function getName()
        {
            return '电子邮件';
        }

        public function getDescription()
        {
            return '发送一封电子邮件.';
        }

        public function customProcessAddEdit($data, $errors)
        {
            if(strlen($data['subject']) == 0)
                $errors['subject'] = 'Subject cannot be blank.';
            $this->config['subject'] = $data['subject'];

            if(strlen($data['message']) == 0)
                $errors['message'] = 'Message cannot be blank.';
            $this->config['message'] = $data['message'];

            if(@eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $data['address']))
                $errors['address'] = 'E-mail address is invalid.';
            $this->config['address'] = $data['address'];

            return $errors;
        }

        public function customProcessDelete()
        {
        }
        
        public function __toString()
        {
            return $this->config['address'];
        }
    }
?>
