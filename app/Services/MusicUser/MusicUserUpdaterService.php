<?php

namespace App\Services\MusicUser;

use App\Converter\MusicUser\MusicUserToMusicUserResponseConverter;
use App\Dto\Request\MusicUser\MusicUserPatchRequest;
use App\Dto\Request\MusicUser\MusicUserRequest;
use App\Dto\Response\MusicUser\MusicUserResponse;
use App\Models\MusicUserModel;

final class MusicUserUpdaterService{
    private MusicUserModel $model;
    private MusicUserFinderService $finder;
    private MusicUserToMusicUserResponseConverter $converter;


    public function __construct()
    {
        $this->model = new MusicUserModel();
        $this->finder = new MusicUserFinderService();
        $this->converter = new MusicUserToMusicUserResponseConverter();
    }

    public function update(MusicUserRequest $request, int $id): MusicUserResponse
    {
        $musicUser = $this->finder->find($id);
        $musicUser->update($request);
        $musicUser = $this->model->update($musicUser);
        $response = $this->converter->convert($musicUser);

        return $response;
    }

    public function patch(MusicUserPatchRequest $request, int $id): MusicUserResponse
    {
        $musicUser = $this->finder->find($id);

        $musicUser->patch($request);

        $musicUser = $this->model->update($musicUser);

        $response = $this->converter->convert($musicUser);

        return $response;
    }

    public function updateLogo(string $token, string $logo): MusicUserResponse
    {
        $musicUser = $this->model->findByToken($token); // busca por token
        $this->model->updateLogo($musicUser->getToken(), $logo); // usa el id
        $musicUser->setLogoPath($logo);

        return $this->converter->convert($musicUser);

    }
public function updateRole(string $token, string $role): MusicUserResponse
{
    $musicUser = $this->model->findByToken($token); 
    

    $this->model->updateRole($musicUser->getToken(), $role); 

    
    $musicUser->setRole($role); 

    return $this->converter->convert($musicUser);
}


}