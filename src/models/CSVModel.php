<?php

namespace gurikin\csvwork\models;


use gurikin\csvwork\models\Helpers\GeneratorHelper;
use Yii;
use yii\base\Model;


/* TODO for the version 1.1: create tne class CSVStringModel - the instance of csv file string and use it instead the simple array with creating field of class from the columns head*/
/* TODO for the version 1.1: create the custom CSVDataProvider class that can read, sort & search in CSVStringModel*/

/**
 * Class CSVModel
 * @package gurikin\csvwork\models
 */
class CSVModel extends Model
{
    /**
     * @var string имя CSV-файла для чтения
     */
    public $filename;

    /**
     * @var SplFileObject
     */
    protected $fileObject; // с помощью SplFileObject очень удобно искать конкретную строку в файле

    /**
     * @var string Имя поля для передачи в анонимную функцию для фильтрации
     */
    protected $filterField;

    /**
     * CSVModel constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        // открыть файл
        if (!file_exists($this->filename)) {
            $f = fopen($this->filename, 'c+');
            fclose($f);
        }
        $this->fileObject = new \SplFileObject($this->filename);
    }

    /**
     * @return array
     */
    public function getModel()
    {
        $models = [];
        $this->fileObject->seek($id = 1);
        $columns = $this->getColumnHeads();
        while (!$this->fileObject->eof()) {
            $csvString = $this->fileObject->fgetcsv()[0];
            if ($csvString != null) {
                $values[] = $id - 1;
                foreach (explode(";", $csvString) as $value) {
                    $values[] = $value;
                }
                $models[] = array_combine($columns, $values);
                $id++;
                $values = null;
            }
        }

        return $models;
    }

    /**
     * @return array|bool
     */
    private function getColumnHeads()
    {
        if ($this->fileObject !== null) {
            $this->fileObject->seek(0);
            $columnHeads[] = 'stringNumber';
            foreach (explode(";", $this->fileObject->fgetcsv()[0]) as $column) {
                $columnHeads[] = $column;
            }
            return $columnHeads;
        }
        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public function findOne($id) {
        $columns = $this->getColumnHeads();
        $this->fileObject->seek($id);
        $values[] = $id;
        foreach (explode(";", $this->fileObject->fgetcsv()[0]) as $value) {
            $values[] = $value;
        }
        $model = array_combine($columns,$values);
        return $model;
    }

    /**
     * @param $id
     */
    public function delete($id) {
        try {
            while (!$this->fileObject->eof()) {
                $getValue = $this->fileObject->fgetcsv()[0];
                $deletedArray[] = $getValue."\n";
            }
            $id++;
            unset($deletedArray[$id]);
            $fileObject = new \SplFileObject($this->filename, 'w');
            foreach ($deletedArray as $putValue) {
                $fileObject->fwrite($putValue);
            }
        } catch (Exception $ex) {
            echo($ex);
        }
    }

    /**
     * @param $model
     * @return bool
     */
    public function save($model) {
        try {
            $this->fileObject->seek(0);
            while (!$this->fileObject->eof()) {
                $getValue = $this->fileObject->fgetcsv()[0];
                $updatedArray[] = $getValue."\n";
            }
            $updateModel = $model;
            array_shift($updateModel);
            $updatedString = implode(";",$updateModel)."\n";
            $updatedArray[$model['stringNumber']+1] = $updatedString;

            $fileObject = new \SplFileObject($this->filename, 'w');

            foreach ($updatedArray as $putValue) {
                $fileObject->fwrite($putValue);
            }
        } catch (Exception $ex) {
            echo $ex;
            return false;
        }
        return false;
    }

    /**
     * @param $model
     * @param $field
     * @return array
     */
    public function filter($model, $field)
    {
        $this->filterField = $field;
        return array_filter($model, function ($item) {
            $namefilter = Yii::$app->request->getQueryParam('filter'.$this->filterField, '');
            if (strlen($namefilter) > 0) {
                if (strpos($item[$this->filterField], $namefilter) != false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        });
    }
}
