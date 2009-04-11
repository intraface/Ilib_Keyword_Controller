<?php
class Intraface_Keyword_Controller_Connect extends k_Controller
{
    function GET()
    {
        $kernel = $this->registry->get('intraface:kernel');
        $kernel->useShared('keyword');
        $translation = $kernel->getTranslation('keyword');

        if (!empty($this->GET['filemanager_id']) AND is_numeric($this->GET['filemanager_id'])) {
            $object_name = 'Ilib_Filehandler_Manager';
            $module = $kernel->module('filemanager');
            $id = (int)$_REQUEST['filemanager_id'];
            $id_name = 'filemanager_id';
            $redirect = 'filemanager/file';
            $object = new $object_name($kernel, $id);
        } else {
            throw new Exception('Der er ikke angivet noget objekt i /keyword/connect.php');
        }

        $options = array('extra_db_condition' => 'intranet_id = '.intval($kernel->intranet->get('id')));
        $redirect = Ilib_Redirect::receive($kernel->getSessionId(), $this->registry->get('database:mdb2'), $options);
        $redirect->setDestination($this->url('../edit'), $this->url('../connect', array($id_name => $object->get('id'))));

        if (!empty($this->GET['delete']) AND is_numeric($this->GET['delete'])) {
            $keyword = new Ilib_Keyword($object, $this->GET['delete']);
            $keyword->delete();
        }

        $keyword = $object->getKeywords();
        $appender = $object->getKeywordAppender(); // starter objektet
        $keywords = $keyword->getAllKeywords(); // henter alle keywords
        $keyword_string = $appender->getConnectedKeywordsAsString();

        // finder dem der er valgt
        $checked = array();
        foreach($appender->getConnectedKeywords() as $key) {
            $checked[] = $key['id'];
        }

        $this->document->title = $this->__('add keywords to') . ' ' . $object->get('name');

        $data = array('object' => $object, 'keyword' => $keyword, 'keywords' => $keywords, 'id_name' => $id_name, 'checked' => $checked);

        return $this->render(dirname(__FILE__) . '/../templates/connect.tpl.php', $data);
    }

    function POST()
    {
        $kernel = $this->registry->get('intraface:kernel');
        $kernel->useShared('keyword');
        $translation = $kernel->getTranslation('keyword');

        if (!empty($this->POST['filemanager_id']) AND is_numeric($this->POST['filemanager_id'])) {
            $object_name = 'Ilib_Filehandler_Manager';
            $module = $kernel->module('filemanager');
            $id = (int)$_REQUEST['filemanager_id'];
            $id_name = 'filemanager_id';
            $redirect = 'filemanager/file';
            $object = new $object_name($kernel, $id);
        } else {
            throw new Exception('Der er ikke angivet noget objekt i /keyword/connect.php');
        }

        $keyword = $object->getKeywordAppender(); // starter keyword objektet

        if (!$keyword->deleteConnectedKeywords()) {
            $keyword->error->set('Kunne ikke slette keywords.');
        }

        // strengen med keywords
        if (!empty($this->POST['keywords'])) {
            $appender = new Ilib_Keyword_StringAppender(new Ilib_Keyword($object), $keyword);
            $appender->addKeywordsByString($this->POST['keywords']);
        }

        // listen med keywords
        if (!empty($this->POST['keyword']) AND is_array($this->POST['keyword']) AND count($this->POST['keyword']) > 0) {
            for($i=0, $max = count($this->POST['keyword']); $i < $max; $i++) {
                $keyword->addKeyword(new Ilib_Keyword($object, $this->POST['keyword'][$i]));
            }
        }

        if (!empty($this->POST['close'])) {
            throw new k_http_Redirect($this->url('/filemanager/'. $id));
        } else {
            throw new k_http_Redirect($this->url(null, array('filemanager_id' => $id)));
        }

    }
}