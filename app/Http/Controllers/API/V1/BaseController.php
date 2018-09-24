<?php
 
namespace App\Http\Controllers\API\V1;
use App\Traits\Restable;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;



class BaseController extends Controller  
{

    use ValidatesRequests, Restable;

    public function sendResponse($result , $message,$code = 200){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
            'status_code' => $code
        ];
        return response()->json($response , 200);
    }

    public function sendError($error , $errorMessages = [] , $code = 404){
        $response = [
            'success' => false ,
            'message' => $error,
            'status_code' => $code

        ];
        if (!empty($errorMessages)) {
            # code...
            $response['date'] = $errorMessages;
        }
        return response()->json($response , $code);
        
    }

    public function transformCollection(Collection $items ) : Collection
    {
        return $items->map(function ( $item ){
            return $this->transform($item  );
        });
    }

    /**
     * The default pagination size.
     *
     * @var int The pagination size
     */
    protected $pagination = 10;
    /**
     * The maximum pagination size.
     *
     * @var int The pagination size
     */
    protected $maxLimit = 50;
    /**
     * The minimum pagination size.
     *
     * @var int The pagination size
     */
    protected $minLimit = 1;

    /**
     * Getter for the pagination.
     *
     * @return int The pagination size
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Sets and checks the pagination.
     *
     * @param int $pagination The given pagination
     */
    public function setPagination($pagination)
    {
        $this->pagination = (int) $this->checkPagination($pagination);
    }

    /**
     * Checks the pagination.
     *
     * @param * $pagination The pagination
     *
     * @return int The corrected pagination
     */
    private function checkPagination($pagination)
    {
        // Pagination should be numeric
        if (!is_numeric($pagination)) {
            return $this->pagination;
        }
        // Pagination should not be less than the minimum limitation
        if ($pagination < $this->minLimit) {
            return $this->minLimit;
        }
        // Pagination should not be greater than the maximum limitation
        if ($pagination > $this->maxLimit) {
            return $this->maxLimit;
        }
        // If the pagination is between the min limit and the max limit, return the pagination
        if (!($pagination > $this->maxLimit) && !($pagination < $this->minLimit)) {
            return $pagination;
        }

        // If all fails, return the default pagination
        return $this->pagination;
    }



    public function uploadFile( $file , $path )
    {
        $filePath = "";      
        $file_name = time().time().uniqid().'.'.$file->getClientOriginalExtension();  
        $fileDir   = base_path() .'/public/assets/'.$path;
        $upload_file = $file->move($fileDir,$file_name); 
        $filePath  = '/public/assets/'.$path.$file_name;

        return $filePath;   
    }
  
}
