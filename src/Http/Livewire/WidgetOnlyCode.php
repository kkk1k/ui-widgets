<?php
namespace Jiny\Widgets\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class WidgetOnlyCOde extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Upload;


    public $widget=[]; // 위젯정보
    public $setup = false;

    public $upload_path;

    public $viewFile;
    public $rows = [];

    public $popupForm = false;
    public $viewForm;
    public $viewList;

    public $popupDelete = false;
    public $confirm = false;

    public $actions = [];
    public $forms = [];
    public $edit_id;

    use \Jiny\Widgets\Http\Trait\DesignMode;
    use \Jiny\Widgets\Http\Trait\WidgetSaveJson;

    public function mount()
    {
        $this->dataload();

        $this->viewListFile();
        $this->viewFormFile();

        // 데이터 파일명과 동일한 구조의 url 경로로 임시설정
        $this->upload_path = "/".str_replace(".", "/", $this->filename);
    }

    public function render()
    {
        if(!$this->filename) {
            return <<<EOD
            <div>Widget 데이터 파일명이 없습니다.</div>
            EOD;
        }

        if(!$this->viewFile) {
            $this->viewFile = 'jiny-widgets::code.preview.layout';
        }

        return view($this->viewFile);
    }

    protected function viewListFile()
    {
        if(!$this->viewList) {
            $this->viewList = 'jiny-widgets::code.preview.code';
        }
    }

    protected function viewFormFile()
    {
        if(!$this->viewForm) {
            $this->viewForm = "jiny-widgets::code.preview.form";
        }
    }

    protected $listeners = [
        'create','popupFormCreate',
        'edit','popupEdit','popupCreate'
    ];

    public $forms_old;
    public function modify()
    {
        $this->popupForm = true;
        $this->forms = $this->rows;
        $this->forms_old = $this->rows;
    }


    public function update()
    {
        // 2. 시간정보 생성
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        // 3. 파일 업로드 체크 Trait
        $this->fileUpload($this->forms, $this->upload_path);

        // 이미지삭제
        $this->deleteUploadFiles($this->forms, $this->forms_old);

        $this->rows = $this->forms;
        $this->widget['items'] = $this->rows;
        $this->widgetSave($this->widget, $this->filename);

        $this->forms = [];
        $this->edit_id = null;
        $this->popupForm = false;
        $this->setup = false;
    }


    public function cancel()
    {
        $this->forms = [];
        $this->edit_id = null;
        $this->popupForm = false;
        $this->setup = false;
    }

    protected function deleteUploadFiles($form, $old=null)
    {
        $path = storage_path('app');
        $type_name = ["image", "img", "images", "upload"];

        foreach($form as $key => $item) {
            if(in_array($key, $type_name)) {

                // 수정 케이스
                if($old && isset($old[$key]) && isset($form[$key])) {
                    if($old[$key] != $form[$key]) {
                        $filepath = $path."/".$old[$key];
                        if(file_exists($filepath)) {
                            unlink($filepath);
                        }
                    }
                }
                // 삭제 케이스
                else {
                    $filepath = $path."/".$item;
                    if(file_exists($filepath)) {
                        unlink($filepath);
                    }
                }
            }
        }
    }


    public function setting()
    {
        $this->popupForm = true;
        $this->setup = true;
    }

}