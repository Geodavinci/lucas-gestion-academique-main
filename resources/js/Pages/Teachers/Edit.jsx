import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ teacher }) {
    const form = useForm({
        nom: teacher.nom || '',
        prenom: teacher.prenom || '',
        email: teacher.email || '',
        telephone: teacher.telephone || '',
        specialite: teacher.specialite || '',
    });

    return (
        <AuthenticatedLayout>
            <Head title="Modifier enseignant" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Modifier enseignant</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.put(route('teachers.update', teacher.id));
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
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre à jour</button>
                        <Link href={route('teachers.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
