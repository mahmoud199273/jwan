<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class CoreController extends Controller {

	function __construct()
	{
		// parent::__construct();
		if ($this->auto_set_property == true) {
			$this->setCustomProperty();
			$this->request = request();

		}
		view()->share(array(
			'module_name'=>$this->module_name,
			'route'=>$this->route,
			'path'=>$this->path,
			'base_view'=>$this->base_view,
		));
	}

	protected $request ;
	protected $model ;

	/************************************ Custom Property ************************************/



	/**
	 * auto set module property
	 * @var boolean
	 */
	protected $auto_set_property = true;

	/**
	 * Breadcrumb for view
	 * @var array
	 */
	protected $breadcrumb = array();

	/**
	 * name of module which appear on view
	 * @var string
	 */
	protected $module_name;


	/**
	 * Resource Route For Pagination
	 * @var string
	 */
	protected $route;


	/**
	 * all modules base
	 * @var string
	 */
	protected $base_view = 'admin';

	/**
	 * Path of view file
	 * the Base id views/admin folder .
	 * EX : if you have folder called user inside admin folder just add
	 * user
	 * @var string
	 */
	protected $path;

	/**
	 * array of columns to show in index
	 * @var array
	 */
	protected $show_columns_html = array();


	/**
	 * array of columns to will select from query
	 * @var array
	 */
	protected $show_columns_select = array();



	/**
	 * Main column is main column where use to title page on edit/show
	 */

	protected $main_column;

	/**
	 * Customize Column in datatable
	 */
	protected $custom_columns = [];

	/**
	 * Add custom column
	 */
	protected $add_columns = [];

	/**
	 * remove columns
	 */
	protected $remove_columns = [];


	/**
	 * make following column read as html
	 */
	protected $escape_columns = [];





	/************************************ Custom Property ************************************/



	/**
	 * Number of Rows per page , if you need no limit you can make it 99999999999999999
	 * @var integer
	 */
	// protected $perPage = 20;

	/**
	 * Ordering ASC or DESC
	 * @var array
	 */
	protected $orderBy = array('id','desc');

	/**
	 * Column in database to search
	 * @var array
	 */
	// protected $searchColumn  = array();

	/**
	 * array of input with attributes and types
	 * formInput is the default
	 * formInput_update is custom for inputs in edit page
	 * @var array
	 */
	protected $formInput = array();
	protected $formInput_update = array();

	/**
	 * create form
	 * @return array create form
	 */

	// abstract protected function formBuilder();


/**
 *
[
	[
		'name'=>'title',
		'type'=>'text',
		'value'=>'lorem apsum',
		'options'=>[
			'id'=>'title',
			'class'=>'form-control'
		]
	],
]

*/







	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->pushBreadcrumb(array('Index'));

		$this->ifMethodExistCallIt('onIndex');
		$this->request->flash();

		$rows = $this->model->orderBy($this->orderBy[0],$this->orderBy[1])->get();

		if($this->request->ajax())
			return response()->json($this->view('loop',[
				'rows'=>$rows,
        		'columns'=>$this->show_columns_html,
        		'select_columns'=>$this->show_columns_select
        	])->render());

		return $this->view('index',array(
			'rows'=>$rows,
	        'columns'=>$this->show_columns_html,
	        'breadcrumb'=>$this->breadcrumb,
	        'select_columns'=>$this->show_columns_select
	     ));
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->pushBreadcrumb(array('create'));
		$this->ifMethodExistCallIt('onCreate');
		return $this->view('create',array(
			'inputs'=>(object)$this->inputs(),
			'breadcrumb'=>$this->breadcrumb
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$this->ifMethodExistCallIt('onStore');
		$insert = $this->model->create($this->request->all());
		$this->ifMethodExistCallIt('isStored', $insert);
		return $this->returnMessage($insert,1);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$this->ifMethodExistCallIt('onShow');
		$row = $this->model->findOrFail($id);
		$main_column = $this->main_column;
		$this->ifMethodExistCallIt('isShowed', $row);
		$this->pushBreadcrumb(array($row->$main_column));
		return $this->view('show',array(
			'row'=>$row,
			'breadcrumb'=>$this->breadcrumb,
		));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$this->ifMethodExistCallIt('onEdit');
		$row = $this->model->findOrFail($id);
		$main_column = $this->main_column;
		$this->pushBreadcrumb(array($row->$main_column));
		return $this->view('edit',array(
			'row'=>$row,
			'inputs'=>$this->inputs(),
			'breadcrumb'=>$this->breadcrumb
		));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$this->ifMethodExistCallIt('onUpdate');
		$row = $this->model->find($id);
		$update = $row->update($this->request->all());
		$this->ifMethodExistCallIt('isUpdated',$row);
		return $this->returnMessage($update,2);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$id = $id ? $id : $this->request->id;
		$row = $this->model->find($id);
		$this->ifMethodExistCallIt('onDestroy',$row);
		$delete = $row->delete();
		$this->ifMethodExistCallIt('isDestroied',$row);
		return $this->returnMessage($delete,3);
	}

	/****************************** Initialization Methods *************************************/

	/**
	 * return message depend on check operation
	 * @param  boolean $operation true return success message, false return failed
	 * @param  int $type      1=> Store , 2=> Update , 3=> Destroy
	 * @param  array $custom_message      ['success'=>'message','failed'=>'message']
	 * @return Voild(Redirect) || Json
	 */
	protected function returnMessage($operation, $type, $custom_message = [])
	{
		if($operation)
		{
			if($this->request->ajax())
				return response()->json(['status'=>'true','message'=>$this->successMessage($type, @$custom_message['success'])]);

			return redirect("admin/$this->route")->with('success',$this->successMessage($type, @$custom_message['success']));
		}
		else
		{
			if($this->request->ajax())
				return response()->json(['status'=>'false','message'=>$this->failedMessage($type, @$custom_message['failed'])]);

			return redirect("admin/$this->route")->with('failed',$this->failedMessage($type, @$custom_message['failed']));
		}
	}

	/**
	 * return success message depend on type
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	protected function successMessage($type = '',$custom_message)
	{
		if (!empty($custom_message))
			return $custom_message;

		switch ($type) {
			case 1:
				return trans("lang.addedsuccessfully");
				break;

			case 2:
				return trans("lang.updatedsuccessfully");
				break;

			case 3:
				return trans("lang.deletedsuccessfully");
				break;

			default:
				return trans("lang.changedsuccessfully");
				break;
		}
	}

	/**
	 * return failed message depend on type
	 * @param  string $type [description]
	 * @return [type]       [description]
	 */
	protected function failedMessage($type = '', $custom_message)
	{
		if (!empty($custom_message))
			return $custom_message;

		switch ($type) {
			case 1:
			return trans("lang.Added Failed");
			break;

			case 2:
			return trans("lang.Updated Failed");
			break;

			case 3:
			return trans("lang.Deleted Failed");
			break;

			default:
			return trans("lang.Operation Failed");
			break;
		}
	}


	/**
	 * Return view function from the Base Folder $base_view
	 * @param  String $view     Filename
	 * @param  array  $variable Pass Variable to View
	 * @return View
	 */
	protected function view($view, array $variable = array())
	{
		return view("$this->base_view.$this->path.$view", $variable);
	}

	/**
	 * inputs creator
	 */
	protected function inputs($formType = 'create')
	{
		// $this->formBuilder();
		$this->ifMethodExistCallIt('formBuilder');
		if (($formType == 'create' && isset($this->formInput) || empty($this->formInput_update) ))
			return $this->formInput;
		else
			return $this->formInput_update;

		/*$this->ifMethodExistCallIt('formBuilder');
		if (!$this->formInput_update) {
			return  $this->formInput;
		}
		return  $this->formInput_update;*/
	}

	/**
	 * auto set almost all Properties
	 */
	/*protected function setCustomProperty()
	{
		# instance of Request
		$this->request = request();

		# get full module breadcrumb
		$class_breadcrumb = $this->generateModuleBreadcrumb();

		$class_name = end($class_breadcrumb);

		array_pop($class_breadcrumb);

		$name = str_replace('Controller', '', $class_name);

		// $lower_name = strtolower($name);
		// $capitlaize_name = ucfirst($lower_name);

		//get module name lower case
		$moduleToLower = $this->convertToLowerCase($name);
		dd($moduleToLower);
		$this->route = $moduleToLower;

		$this->path = $this->getViewPath();
		$getModuleName = str_replace('-', ' ', ucwords($moduleToLower,'-'));

		# convert module name to plural
		$this->module_name = $this->convertToPluralWord($getModuleName);

		$this->breadcrumb = array_merge(array(ucfirst($this->module_name)),$class_breadcrumb);

		$this->main_column = $this->model->getFillable() ? $this->model->getFillable()[0] : 'id';
		$this->searchColumn = $this->searchColumn ? $this->searchColumn : [$this->main_column];
		$this->show_columns_html = $this->show_columns_html ? $this->show_columns_html : [$this->main_column];
		$this->show_columns_select = $this->show_columns_select ? $this->show_columns_select : [$this->main_column];

	}*/



	protected function setCustomProperty()
	{
		# instance of Request
		$this->request = request();

		/*# get full module breadcrumb
		$class_breadcrumb = $this->generateModuleBreadcrumb();

		$class_name = end($class_breadcrumb);

		array_pop($class_breadcrumb);

		$name = str_replace('Controller', '', $class_name);

		// $lower_name = strtolower($name);
		// $capitlaize_name = ucfirst($lower_name);

		//get module name lower case
		$moduleToLower = $this->convertToLowerCase($name);
		dd($moduleToLower);
		$this->route = $moduleToLower;

		$this->path = $this->getViewPath();
		$getModuleName = str_replace('-', ' ', ucwords($moduleToLower,'-'));

		# convert module name to plural
		$this->module_name = $this->convertToPluralWord($getModuleName);*/

		// $this->breadcrumb = array_merge(array(ucfirst($this->module_name)),$class_breadcrumb);

		# generate class's breadcrumb
		$class_breadcrumb = $this->generateModuleBreadcrumb();
		$this->createModuleName($class_breadcrumb);
		$this->createViewPath($class_breadcrumb);
		$this->createBreadcrumb($class_breadcrumb);
		$this->createRoute($class_breadcrumb);

		// $this->route = $this->returnModuleNameSpliteWthDashes($class_breadcrumb);

		$this->main_column = $this->model->getFillable() ? $this->model->getFillable()[0] : 'id';
		// $this->searchColumn = $this->searchColumn ? $this->searchColumn : [$this->main_column];
		$this->show_columns_html = $this->show_columns_html ? $this->show_columns_html : [$this->main_column];
		$this->show_columns_select = $this->show_columns_select ? $this->show_columns_select : [$this->main_column];

	}


	public function returnModuleNameSpliteWthDashes($class_breadcrumb)
	{
		$class_name = end($class_breadcrumb);

		$name = str_replace('Controller', '', $class_name);

		return $this->convertToLowerCase($name);
	}

	public function createModuleName($class_breadcrumb)
	{
		$moduleToLower = $this->returnModuleNameSpliteWthDashes($class_breadcrumb);

		$getModuleName = str_replace('-', ' ', ucwords($moduleToLower,'-'));

		$this->module_name = $this->convertToPluralWord($getModuleName);
	}

	public function createViewPath($class_breadcrumb)
	{
		$moduleToLower = $this->returnModuleNameSpliteWthDashes($class_breadcrumb);

		array_pop($class_breadcrumb);
		$arr = [];
		foreach ($class_breadcrumb as $key => $c)
			$arr[] = strtolower($c);

		$arr[] = $moduleToLower;

		$this->path = implode('.',$arr);
	}

	public function createBreadcrumb($class_breadcrumb)
	{
		array_pop($class_breadcrumb);
		$arr = [];
		foreach ($class_breadcrumb as $key => $c)
			$arr[] = ucfirst($c);

		$this->breadcrumb = array_merge($arr ,array($this->module_name));
	}

	public function createRoute($class_breadcrumb)
	{
		$moduleToLower = $this->returnModuleNameSpliteWthDashes($class_breadcrumb);

		array_pop($class_breadcrumb);
		$arr = [];
		foreach ($class_breadcrumb as $key => $c)
			$arr[] = strtolower($c);

		array_push($arr, $moduleToLower);
		$this->route = implode('/',$arr);
	}




	/**
	 * convert word to plural to show model name in frontend
	 * @param  String $string
	 * @return String
	 */
	public function convertToPluralWord($string)
	{
		return substr($string, -1) == 's' ? $string :
				(substr($string,-1) == 'y' ? rtrim($string,'y').'ies' :
				(substr($string,-1) == 'a' ? $string : $string.'s') ) ;
	}



	/**
	 * Generate Breadcrumb refer to class breadcrumb and view
	 * @param  String $string
	 * @return String
	 */
	public function generateModuleBreadcrumb()
	{
		# get namespace of CoreController
		# App\Http\Controllers\Admin\CoreController .. will return Admin
		$currentNamespace = explode('\\', __NAMESPACE__);
		$currentNamespace = array_pop($currentNamespace);

		# get namespace of called class
		$namespaces = explode('\\', get_called_class());
		$boolean = false;
		$module_breadcrumb = [];
	    foreach ($namespaces as $key => $namespace) {
	    	if ($boolean)
	    		$module_breadcrumb[] = $namespace;
	    	else
	    		$boolean = $namespace == $currentNamespace;
	    }

	    return $module_breadcrumb;
	}


/**
	 * Generate Breadcrumb refer to class breadcrumb and view
	 * @param  String $string
	 * @return String
	 */
	public function getViewPath()
	{
		$breadcrumb = $this->generateModuleBreadcrumb();
		array_pop($breadcrumb);
		$path = '';
		foreach ($breadcrumb as $key => $c) {
			if ($key == 0)
				$path += strtolower($c);
		}
	}








	protected function getClassName() {
		$path = explode('\\', get_called_class());
		return array_pop($path);

	}

	/**
	 * Convert $string to lower case
	 * @param  String $string
	 * @return String
	 */
	protected function convertToLowerCase($string)
	{
		return strtolower(preg_replace('/\B([A-Z])/', '-$1', $string));
	}

	/**
	 * create breadcrumb
	 * @param  array  $arr array of breadcrumb which send to view
	 * @return [type]      [description]
	 */
	protected function pushBreadcrumb(array $arr)
	{
		foreach ($arr as $key => $value) {
			array_push($this->breadcrumb,ucfirst($value));
		}
	}


	/**
	 * used for launch custom events like :
	 * onStore,isStored
	 * onUpdate,isUpdated
	 * @param string $method [function name]
	 * @param array $method [pass paramter to function]
	 */
	public function ifMethodExistCallIt($method,$args = [])
	{
		if (method_exists($this, $method)) {
			$this->$method($args);
		}
	}


	/**
	 * short cut for validation function
	 */
	public function v($rules = [], $messages = [])
	{
		$this->validate($this->request,$rules,$messages);
	}

}

