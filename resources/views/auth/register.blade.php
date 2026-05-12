
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded border border-slate-200 shadow-sm">
    <h1 class="text-2xl font-semibold mb-4">Inscription</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nom</label>
            <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <div>
            <label class="block text-sm font-medium">Mot de passe</label>
            <input type="password" name="password" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <div>
            <label class="block text-sm font-medium">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <button type="submit" class="w-full rounded bg-slate-900 text-white px-4 py-2 text-sm">Creer un compte</button>
    </form>
</div>
@endsection

