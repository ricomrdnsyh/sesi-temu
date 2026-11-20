<?php

namespace App\Policies;

use App\Models\Pengguna;
use App\Models\Undangan;

class UndanganPolicy
{
    public function before(Pengguna $pengguna, string $ability): ?bool
    {
        if ($pengguna->adalahAdmin()) {
            return true;
        }

        return null;
    }

    public function kelola(Pengguna $pengguna, Undangan $undangan): bool
    {
        return $pengguna->id === $undangan->pengguna_id;
    }

    public function hapus(Pengguna $pengguna, Undangan $undangan): bool
    {
        return $pengguna->id === $undangan->pengguna_id && $undangan->bolehDihapusClient();
    }
}
