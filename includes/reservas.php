<?php
function reservas_file_path() {
    return __DIR__ . '/../data/reservas.csv';
}

function reservas_headers() {
    return ['id', 'fecha_registro', 'nombre', 'telefono', 'personas', 'servicio', 'fecha_visita', 'hora', 'mensaje', 'estado'];
}

function read_reservas() {
    $path = reservas_file_path();
    if (!file_exists($path)) {
        return [];
    }

    $handle = fopen($path, 'r');
    if (!$handle) {
        return [];
    }

    $headers = fgetcsv($handle);
    if (!$headers) {
        fclose($handle);
        return [];
    }

    $rows = [];
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) === count($headers)) {
            $rows[] = array_combine($headers, $data);
        }
    }
    fclose($handle);
    return array_reverse($rows);
}

function append_reserva($row) {
    $path = reservas_file_path();
    $exists = file_exists($path) && filesize($path) > 0;
    $handle = fopen($path, 'a');
    if (!$handle) {
        return false;
    }

    if (flock($handle, LOCK_EX)) {
        if (!$exists) {
            fputcsv($handle, reservas_headers());
        }
        fputcsv($handle, [
            $row['id'],
            $row['fecha_registro'],
            $row['nombre'],
            $row['telefono'],
            $row['personas'],
            $row['servicio'],
            $row['fecha_visita'],
            $row['hora'],
            $row['mensaje'],
            $row['estado'],
        ]);
        fflush($handle);
        flock($handle, LOCK_UN);
    }

    fclose($handle);
    return true;
}

function save_reservas($reservas) {
    $path = reservas_file_path();
    $handle = fopen($path, 'w');
    if (!$handle) {
        return false;
    }

    if (flock($handle, LOCK_EX)) {
        fputcsv($handle, reservas_headers());
        foreach (array_reverse($reservas) as $row) {
            fputcsv($handle, [
                $row['id'],
                $row['fecha_registro'],
                $row['nombre'],
                $row['telefono'],
                $row['personas'],
                $row['servicio'],
                $row['fecha_visita'],
                $row['hora'],
                $row['mensaje'],
                $row['estado'],
            ]);
        }
        fflush($handle);
        flock($handle, LOCK_UN);
    }

    fclose($handle);
    return true;
}
