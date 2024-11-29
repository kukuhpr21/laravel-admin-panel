<?php

namespace App\Utils;

use App\Utils\CryptUtils;

class SessionUtils
{
    private string $key = "s47qnsadub";

    private function getMain(): array
    {
        $encValue = session()->get($this->key);
        if ($encValue === null) {
            return [];
        }

        return CryptUtils::dec($encValue) ?? [];
    }

    public function save(string $key, string $value): void
    {
        $mainValue       = $this->getMain();
        $mainValue[$key] = $value;
        $encValue        = CryptUtils::enc($mainValue);
        session()->put($this->key, $encValue);
    }

    public function get(string $key): string
    {
        $mainValue = $this->getMain();
        if (array_key_exists($key, $mainValue)) {
            return $mainValue[$key];
        }
        return "";
    }

    public function delete(string $key): void
    {
        $mainValue = $this->getMain();
        unset($mainValue[$key]);
        $encValue = CryptUtils::enc($mainValue);
        session()->put($this->key, $encValue);
    }

    public function deleteMain(): void
    {
        session()->remove($this->key);
    }

    public function isExist(): bool
    {
        return count($this->getMain()) > 0;
    }
}
