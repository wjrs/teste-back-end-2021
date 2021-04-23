<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\StorageService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $storage;

    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }


    public function index()
    {
        $products = Product::all();

        return responder()->success($products)->respond(200);
    }

    public function store(Request $request)
    {
        try {
            $input = $request->all();

            if ($request->hasFile('photo')) {
                $fileUrl = $this->storage->upload($request, 'photo', 'products');
                $input['photo'] = $fileUrl;
            }
            $product = Product::create($input);

            return responder()->success($product)->respond(201);
        } catch (\Exception $e) {
            return responder()->error($e->getCode(), 'Erro ao salvar: '.$e->getMessage())->respond(404);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (is_null($product)) {
                throw new \Exception('Produto não localizado.');
            }

            return responder()->success($product)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getCode(), 'Erro ao buscar: '.$e->getMessage())->respond(404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $input = $request->all();
            $product = Product::find($id);

            if (is_null($product)) {
                throw new \Exception('Produto não localizado.');
            }

            if ($request->hasFile('photo')) {

                if (!is_null($product->photo)) {
                    $this->storage->delete($product->photo);
                }
                $fileUrl = $this->storage->upload($request, 'photo', 'products');
                $input['photo'] = $fileUrl;
            }
            $product->update($input);

            return responder()->success($product)->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getCode(), 'Erro ao atualizar: '.$e->getMessage())->respond(404);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (is_null($product)) {
                throw new \Exception('Produto não localizado.');
            }

            if (!is_null($product->photo)) {
                $this->storage->delete($product->photo);
            }

            $product->delete();

            return responder()->success(['message' => 'Produto excluído com sucesso.'])->respond(200);
        } catch (\Exception $e) {
            return responder()->error($e->getCode(), 'Erro ao excluir: '.$e->getMessage())->respond(404);
        }
    }
}
