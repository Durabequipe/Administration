<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class VideoCanChooseThemeUniqueInProject implements ValidationRule
{
    private Project $project;

    public function __construct(string $projectID)
    {
        $this->project = Project::find($projectID);
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $canChooseThemeExist = $this->project->videos()->where('can_choose_theme', true)->exists();
        if ($value && $canChooseThemeExist) {
            $fail('Une seule vidéo peut avoir la possibilité de choisir un thème.');
        }
    }
}
