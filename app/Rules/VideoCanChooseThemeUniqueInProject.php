<?php

namespace App\Rules;

use App\Models\Project;
use App\Models\Video;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class VideoCanChooseThemeUniqueInProject implements ValidationRule
{
    private Project $project;
    private ?Video $video;

    public function __construct(string $projectID, ?string $videoID)
    {
        $this->project = Project::find($projectID);
        $this->video = Video::find($videoID);
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $canChooseThemeExist = $this->project->videos()
            ->where('can_choose_theme', true)
            ->where('id', '!=', $this->video?->id)
            ->exists();
        if ($value && $canChooseThemeExist) {
            $fail('Une seule vidéo peut avoir la possibilité de choisir un thème.');
        }
    }
}
