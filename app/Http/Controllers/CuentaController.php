<?php
namespace App\Http\Controllers;

use App\Services\CuentaService;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    protected $cuentaService;

    public function __construct(CuentaService $cuentaService)
    {
        $this->cuentaService = $cuentaService;
    }

    public function index(Request $request)
    {
        $userId = $request->query('user_id', auth()->id());
        $cuentas = $this->cuentaService->listarCuentas($userId);
        return response()->json(['success' => true, 'data' => $cuentas]);
    }


    public function store(Request $request)
    {
        $datos = $request->validate([
            'user_id'       => 'required|string',
            'tipo'          => 'required|in:corriente,ahorro',
            'numero_cuenta' => 'required|string|max:20',
            'saldo'         => 'required|numeric|min:0',
            'moneda'        => 'in:PEN,USD',
        ]);
        try {
            $userId = $datos['user_id'];
            unset($datos['user_id']);
            $cuenta = $this->cuentaService->crearCuenta($datos, $userId);
            return response()->json(['success' => true, 'data' => $cuenta], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $cuenta = $this->cuentaService->obtenerCuenta($id, auth()->id());
            return response()->json(['success' => true, 'data' => $cuenta]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cuenta no encontrada'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $datos = $request->validate([
            'tipo'   => 'in:corriente,ahorro',
            'saldo'  => 'numeric|min:0',
            'moneda' => 'in:PEN,USD',
        ]);
        try {
            $cuenta = $this->cuentaService->actualizarCuenta($id, $datos, auth()->id());
            return response()->json(['success' => true, 'data' => $cuenta]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->cuentaService->eliminarCuenta($id, auth()->id());
            return response()->json(['success' => true, 'message' => 'Cuenta eliminada']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function resumen()
    {
        $resumen = $this->cuentaService->obtenerResumen(auth()->id());
        return response()->json(['success' => true, 'data' => $resumen]);
    }
}

