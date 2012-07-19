<?php
    class ConnectionMonitor extends Monitor
    {
        public function getName()
        {
            return '连接监控';
        }

        public function getDescription()
        {
            return '这种类型的监控尝试建立一套接字连接到所需的端点。如果
                    连接不成功,服务被认为是“离线“';
        }

        public function getTimeout()
        {
            return $this->config['timeout'];
        }

        public function queryMonitor()
        {
            $sock = @fsockopen($this->hostname, $this->port, $errno, $errstr, $this->config['timeout']);
            if($sock)
            {
                fclose($sock);
                return true;
            }
            return false;
        }

        public function customProcessAddEdit($data, $errors)
        {
            if(!is_numeric($data['timeout']) || intval($data['timeout']) <= 0)
                $errors['timeout'] = 'Timeout must be a positive integer.';
            $this->config['timeout'] = intval($data['timeout']);
            return $errors;
        }

        public function customProcessDelete()
        {
        }
    }
?>
