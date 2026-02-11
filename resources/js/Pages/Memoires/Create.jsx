import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ students }) {
    const form = useForm({
        student_id: '',
        titre: '',
        annee: '',
        fichier_pdf: null,
    });

    return (
        <AuthenticatedLayout>
            <Head title="Nouveau mémoire" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-2xl font-semibold">Nouveau mémoire</h1>
                    <Link href={route('memoires.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">Retour</Link>
                </div>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('memoires.store'), { forceFormData: true });
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
                        <label className="block text-sm font-medium">Titre</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.titre} onChange={(e) => form.setData('titre', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Année</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.annee} onChange={(e) => form.setData('annee', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Fichier PDF</label>
                        <input type="file" className="mt-1 w-full rounded border-slate-300 bg-white" onChange={(e) => form.setData('fichier_pdf', e.target.files[0])} />
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                        <Link href={route('memoires.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
