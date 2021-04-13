<?php


namespace App\Services;


use Exception;
use Illuminate\Support\Str;
use App\Models\SafeVar;

class SafeVarService
{
    public function add($value)
    {
        if (!$value) {
            throw new Exception('$value must be specified.');
        }

        if (strlen($value) > 32) {
            throw new Exception('$value must be contain less than 32 characters.');
        }

        while (true) {
            $uuid = Str::random();

            if (self::isUuidAvailable($uuid)) {
                break;
            }
        }

        $data = [
            'uuid' => $uuid,
            'value' => $value
        ];

        $newSafeVar = SafeVar::create($data);

        return $newSafeVar->uuid;
    }

    public function get($uuid = null)
    {
        $var = SafeVar::valid()->select(['value'])->find($uuid);

        if ($var) {
            return $var->value;
        } else {
            return null;
        }
    }

    public function destroy($uuid)
    {
        SafeVar::destroy($uuid);
    }

    private function isUuidAvailable($uuid)
    {
        return SafeVar::find($uuid) === null;
    }
}
