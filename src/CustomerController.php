<?php

namespace Wooturk;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
	function index(Request $request){
		$data = [
			['GET', 'customers', 'Kullanıcı listesi'],
			['GET', 'customer', 'Servis Açıklaması'],
			['POST', 'customer', 'Kullanıcı Oluşturma'],
			['GET', 'customer/{id}', 'Tek Bir Kullanıcı Bilgisi'],
			['PUT', 'customer/{id}', 'Tek Bir Kullanıcı Günceleme'],
			['DELETE', 'customer/{id}', 'Tek Bir Kullanıcı Silme'],
		];
		return Response::success("Lütfen Giriş Yapınız", $data);
	}
	function list(Request $request){
		if($rows = get_customers( $request->all() )){
			return Response::success("Kullanıcı Bilgileri", $rows);
		}
		return Response::failure("Kullanıcı Bulunamadı");
	}
	function get(Request $request, $id){
		if($row = get_customer($id)){
			return Response::success("Kullanıcı Bilgileri", $row);
		}
		return Response::failure("Kullanıcı Bulunamadı");
	}
	function post(Request $request) {
		if (!$request->hasHeader('X-Wooturk-Key')) {
			return Response::failure("Bu işlem için yetkili değilsiniz");
		}
		if($request->header('X-Wooturk-Key')!=env('WOOTURK_KEY')){
			return Response::failure("Anahtarnız bu işlem için geçerli değil");
		}
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'email'      => 'required|email|unique:customers',
				'password'   => 'required|string|max:16',
			]);
			$row = create_customer($fields);
			if($row){
				return Response::success("Kullanıcı Oluşturuldu", $row);
			}
			return Response::failure("Kullanıcı Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
	function put(Request $request, $id){
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'password'   => 'required|string|max:16',
			]);

			$row = update_customer($id, $fields);
			if($row){
				return Response::success("Kullanıcı Güncellendi", $row);
			}
			return Response::failure("Kullanıcı Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			if( $row = delete_customer($id)){
				return Response::success("Kullanıcı Silindi", $row);
			}
			return Response::failure("Kullanıcı Bulunamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
}
