import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ students, filieres }) {
    const form = useForm({
        student_id: '',
        filiere_id: '',
        annee_academique: `${new Date().getFullYear()}-${new Date().getFullYear() + 1}`,
    });

    return (
        <AuthenticatedLayout>
            <Head title="Nouvelle inscription" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Nouvelle inscription</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('enrollments.store'));
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    <div>
                        <label className="block text-sm font-medium">Étudiant</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.student_id} onChange={(e) => form.setData('student_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {students.map((s) => (
                                <option key={s.id} value={s.id}>{s.nom} {s.prenom} ({s.matricule})</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Filière</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.filiere_id} onChange={(e) => form.setData('filiere_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {filieres.map((f) => (
                                <option key={f.id} value={f.id}>{f.nom} ({f.code})</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Année académique</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.annee_academique} onChange={(e) => form.setData('annee_academique', e.target.value)} />
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                        <Link href={route('enrollments.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
