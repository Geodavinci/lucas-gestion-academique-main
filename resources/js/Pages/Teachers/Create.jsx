import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create() {
    const form = useForm({ nom: '', prenom: '', email: '', telephone: '', specialite: '' });

    return (
        <AuthenticatedLayout>
            <Head title="Ajouter enseignant" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-2xl font-semibold">Nouvel enseignant</h1>
                    <Link href={route('teachers.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">Retour</Link>
                </div>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('teachers.store'));
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    {['nom','prenom','email','telephone','specialite'].map((field) => (
                        <div key={field}>
                            <label className="block text-sm font-medium capitalize">{field}</label>
                            <input className="mt-1 w-full rounded border-slate-300" value={form.data[field]} onChange={(e) => form.setData(field, e.target.value)} />
                        </div>
                    ))}
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                        <Link href={route('teachers.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
