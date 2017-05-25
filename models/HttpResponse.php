<?php

/**
 * APIレスポンス
 * 全てのエンドポイントにて使用
 */
class HttpResponse
{
	private $response = null;

	private static $benchmark = 0;

	public function __construct($params = [])
	{
		self::$benchmark = microtime(true);
		$this->response = (isset($params['response'])) ? $params['response'] : null;
		if (empty($this->response)) {
			throw new Exception('could not initialized', 500);
		}
		$this->response->setHeader('Content-Type', 'application/json; charset=UTF-8');
		$this->response->setHeader('Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, OPTIONS');
		$this->response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type, Authorization');
		header('Access-Control-Allow-Credentials: true');
		$this->setAccessControlAllowOrigin();
	}


	/**
	 * Access-Control-Allow-Origin をセットする
	 * config/config.php で許可するURLを設定しておく
	 *
	 * @return void
	 */
	private function setAccessControlAllowOrigin()
	{
		$httpOrigin = (!empty($_SERVER['HTTP_ORIGIN'])) ? $_SERVER['HTTP_ORIGIN'] : null;
		$this->response->setHeader('Access-Control-Allow-Origin', $httpOrigin);
	}


	/**
	 * 成功した時のレスポンス
	 *
	 * @param string $data
	 * @return void
	 */
	public function success($data = null)
	{
		$this->send(200, 'success', $data);
	}


	/**
	 * 失敗した時のレスポンス
	 *
	 * @param Exception $e
	 * @return void
	 */
	public function error($e)
	{
		$statusCode = (intval($e->getCode()) > 0) ? $e->getCode() : 500;
		$this->send($statusCode, $e->getMessage());
	}


	/**
	 * レスポンスデータの送信
	 *
	 * @param int $statusCode
	 * @param string $resultMessage
	 * @param any $data レスポンスデータ
	 * @return void
	 */
	private function send($statusCode, $resultMessage, $data = null)
	{
		$res = [
			'result' => $resultMessage,
			'data'   => $data,
			'time'   => round(((microtime(true) - self::$benchmark) * 1000), 0, PHP_ROUND_HALF_UP) . 'ms',
		];

		$statusMessage = $this->getStatus($statusCode);
		$this->response->setStatusCode($statusCode, $statusMessage);
		$this->response->setJsonContent($res);
		$this->response->send();
	}


	/**
	 * ステータスコードからステータスを返す
	 *
	 * @param int $statusCode
	 * @return string
	 */
	private function getStatus($statusCode)
	{
		switch ($statusCode) {
			case 200:
				return 'OK';
			case 400:
				return 'Bad Request';
			case 401:
				return 'Unauthorized';
			case 403:
				return 'Forbidden';
			case 404:
				return 'Not Found';
			case 406:
				return 'Not Acceptable';
			case 408:
				return 'Request Timeout';
			case 500:
				return 'Server Error';
			default:
				return '';
		}
	}
}