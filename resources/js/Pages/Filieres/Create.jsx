import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const form = useForm({ nom: '', code: '' });

    return (
        <AuthenticatedLayout>
            <Head title="Nouvelle filière" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Nouvelle filière</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('filieres.store'));
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    <div>
                        <label className="block text-sm font-medium">Nom</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.nom} onChange={(e) => form.setData('nom', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Code</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.code} onChange={(e) => form.setData('code', e.target.value)} />
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                        <Link href={route('filieres.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
