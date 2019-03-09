<?php declare(strict_types=1);

namespace App\Modules\RemoteFilesImporter;

use App\Modules\Interfaces\IRemoteStorageService;
use App\Modules\RemoteFilesImporter\Exceptions\ValidationException;
use Carbon\Carbon;

final class RemoteFilesImporterService
{
    private $remoteStorageService;
    private $repository;

    public function __construct(IRemoteStorageService $remoteStorageService, RemoteFileImporterRepository $repository)
    {
        $this->remoteStorageService = $remoteStorageService;
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getFilesAvailableForImport(): array
    {
        $files = $this->remoteStorageService->getRootDirectoryFiles();

        return array_filter($files, function (string $fileKey) {
            return preg_match('#.json$#', $fileKey);
        });
    }

    /**
     * @param string $key
     * @return int
     * @throws ValidationException
     */
    public function importByKey(string $key): bool
    {
        $filePath = $this->remoteStorageService->downloadRemoteFileByKey($key);
        if (!file_exists($filePath)) {
            throw new ValidationException('Cant download file for import');
        }
        $file = $this->repository->insertFile($key);;
        $fileContent = file($filePath);

        $success = false;
        foreach ($fileContent as $row) {
            $jsonData = json_decode($row);
            if (!empty($jsonData)) {

                $id = $jsonData->profile_id;
                $email = $jsonData->email;


                $profile = $this->repository->insertProfile($file, $id, $email);
                $clicks = $this->repository->insertClicks($jsonData->clicks, $profile);
                $geo = $this->repository->insertGeo([$jsonData->custom_vars->geo], $profile);
                $subscription = $this->repository->insertSubscription($jsonData->custom_vars->current_subscriptions, $profile);
                if (
                    $profile
                    && $clicks
                    && $geo
                    && $subscription
                ) {
                    $success = true;
                }
            }
        }

        return $success;
    }

}
