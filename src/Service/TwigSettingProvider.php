<?php

namespace App\Service;

use App\Entity\Setting;
use App\Repository\SettingRepository;

class TwigSettingProvider
{
    public function __construct(
        private readonly SettingRepository $settingRepository,
    ) {
    }

    public function getSetting(): ?Setting
    {
        return $this->settingRepository->findOneBy([]);
    }
}
