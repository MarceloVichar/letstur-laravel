<?php

namespace App\Http\Api\Controllers\Company\Records;

use App\Domain\Records\Actions\Locale\CreateLocaleAction;
use App\Domain\Records\Actions\Locale\DeleteLocaleAction;
use App\Domain\Records\Actions\Locale\UpdateLocaleAction;
use App\Domain\Records\Actions\Locale\LocaleData;
use App\Domain\Records\Models\Locale;
use App\Http\Api\Requests\Company\Records\LocaleRequest;
use App\Http\Api\Resources\Company\Records\LocaleResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class LocaleController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Locale::class);

        $locales = app(Locale::class)
            ->where('company_id', current_user()->company_id);

        return pagination($locales)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('street'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->defaultSort('created_at')
            ->resource(LocaleResource::class);
    }

    public function show(Locale $locale)
    {
        $this->authorize('view', $locale);

        return LocaleResource::make($locale);
    }

    public function store(LocaleRequest $request)
    {
        $this->authorize('create', Locale::class);

        $data = LocaleData::validateAndCreate([
            'companyId' => current_user()->company_id,
            ...$request->validated(),
        ]);

        $locale = app(CreateLocaleAction::class)
            ->execute($data);

        return LocaleResource::make($locale);
    }

    public function update(LocaleRequest $request, Locale $locale)
    {
        $this->authorize('update', $locale);

        $data = LocaleData::validateAndCreate($request->validated());

        $locale = app(UpdateLocaleAction::class)
            ->execute($locale, $data);

        return LocaleResource::make($locale);
    }

    public function destroy(Locale $locale)
    {
        $this->authorize('delete', $locale);

        app(DeleteLocaleAction::class)
            ->execute($locale);

        return response()->noContent();
    }
}
