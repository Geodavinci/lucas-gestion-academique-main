
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded border border-slate-200 shadow-sm">
    <h1 class="text-2xl font-semibold mb-4">Connexion</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <div>
            <label class="block text-sm font-medium">Mot de passe</label>
            <input type="password" name="password" class="mt-1 w-full rounded border-slate-300" />
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded">
            <label for="remember" class="text-sm">Se souvenir</label>
        </div>

        <button type="submit" class="w-full rounded bg-slate-900 text-white px-4 py-2 text-sm">Se connecter</button>
    </form>
</div>
@endsection

