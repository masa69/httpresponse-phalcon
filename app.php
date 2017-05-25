<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$app->before(function () use ($app) {
	$app->httpResponse = new HttpResponse(['response' => $app->response]);
	return true;
});


/**
 * [OPTIONS]
 * inst
 */
$app->options('/:controller', function () use ($app) {
	$app->response->send();
});

$app->options('/:controller/:action', function () use ($app) {
	$app->response->send();
});

$app->options('/:controller/:action/:params', function () use ($app) {
	$app->response->send();
});


/**
 * Add your routes here
 */
$app->get('/', function () use ($app) {
    try {
		$app->httpResponse->success('httpresponse phalcon');
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});



/** ==================================================
 *
 * success
 *
 * ================================================== */

/**
 * [GET]
 * 参照系
 */
$app->get('/success', function () use ($app) {
	$app->httpResponse->success(['GET_REQUEST', $app->request->getQuery()]);
});


/**
 * [POST]
 * 更新系
 * 主にデータの作成を行う
 */
$app->post('/success', function () use ($app) {
	$app->httpResponse->success(['POST_REQUEST', $app->request->getPost()]);
});


/**
 * [PUT]
 * 主にデータの更新を行う
 */
$app->put('/success', function () use ($app) {
	$app->httpResponse->success(['PUT_REQUEST', $app->request->getPut()]);
});


/**
 * [PATCH]
 * 主にデータの一部更新を行う
 */
$app->patch('/success', function () use ($app) {
	$app->httpResponse->success(['PATCH_REQUEST' => 'https://docs.phalconphp.com/ja/latest/api/Phalcon_Http_Request.html']);
});


/**
 * [DELETE]
 * データの削除を行う
 */
$app->delete('/success', function () use ($app) {
	$app->httpResponse->success(['DELETE_REQUEST' => 'https://docs.phalconphp.com/ja/latest/api/Phalcon_Http_Request.html']);
});



/** ==================================================
 *
 * error
 *
 * ================================================== */

/**
 * [GET]
 * 参照系
 */
$app->get('/error', function () use ($app) {
	try {
		throw new Exception('GET_REQUEST ERROR', 400);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [POST]
 * 更新系
 * 主にデータの作成を行う
 */
$app->post('/error', function () use ($app) {
	try {
		throw new Exception('POST_REQUEST ERROR', 400);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [PUT]
 * 主にデータの更新を行う
 */
$app->put('/error', function () use ($app) {
	try {
		throw new Exception('PUT_REQUEST ERROR', 400);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [PATCH]
 * 主にデータの一部更新を行う
 */
$app->patch('/error', function () use ($app) {
	try {
		throw new Exception('PATCH_REQUEST ERROR', 400);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [DELETE]
 * データの削除を行う
 */
$app->delete('/error', function () use ($app) {
	try {
		throw new Exception('DELETE_REQUEST ERROR', 400);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});



/** ==================================================
 *
 * upload files
 *
 * ================================================== */

/**
 * [POST]
 * 更新系
 * 主にデータの作成を行う
 */
$app->post('/upload', function () use ($app) {
	try {
		if (!$app->request->hasFiles()) {
			throw new Exception('failed upload', 400);
		}
		$app->httpResponse->success([
			'POST_REQUEST', $app->request->getPost(),
			'UPLOAD_FILES', $app->request->getUploadedFiles(),
		]);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [PUT]
 * 主にデータの更新を行う
 */
$app->put('/upload', function () use ($app) {
	try {
		if (!$app->request->hasFiles()) {
			throw new Exception('failed upload', 400);
		}
		$app->httpResponse->success([
			'PUT_REQUEST', $app->request->getPut(),
			'UPLOAD_FILES', $app->request->getUploadedFiles(),
		]);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});


/**
 * [PATCH]
 * 主にデータの一部更新を行う
 */
$app->patch('/upload', function () use ($app) {
	try {
		if (!$app->request->hasFiles()) {
			throw new Exception('failed upload', 400);
		}
		$app->httpResponse->success([
			'PATCH_REQUEST' => 'https://docs.phalconphp.com/ja/latest/api/Phalcon_Http_Request.html',
			'UPLOAD_FILES' => $app->request->getUploadedFiles(),
		]);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});



/** ==================================================
 *
 * not found
 *
 * ================================================== */

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
	try {
		throw new Exception('this endpoint is not found', 404);
	} catch (Exception $e) {
		$app->httpResponse->error($e);
	}
});
