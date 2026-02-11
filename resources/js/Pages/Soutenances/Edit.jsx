import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ soutenance, students, teachers }) {
    const form = useForm({
        date_soutenance: soutenance.date_soutenance || '',
        statut: soutenance.statut || '',
        description: soutenance.description || '',
        student_id: soutenance.student_id || '',
        directeur_memoire_id: soutenance.directeur_memoire_id || '',
        evaluateur_id: soutenance.evaluateur_id || '',
        president_jury_id: soutenance.president_jury_id || '',
    });

    return (
        <AuthenticatedLayout>
            <Head title="Modifier soutenance" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Modifier soutenance</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.put(route('soutenances.update', soutenance.id));
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    <div>
                        <label className="block text-sm font-medium">Date</label>
                        <input type="date" className="mt-1 w-full rounded border-slate-300" value={form.data.date_soutenance} onChange={(e) => form.setData('date_soutenance', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Statut</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.statut} onChange={(e) => form.setData('statut', e.target.value)}>
                            <option value="Valide">Valide</option>
                            <option value="Ajourne">Ajourne</option>
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Étudiant</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.student_id} onChange={(e) => form.setData('student_id', e.target.value)}>
                            {students.map((s) => (
                                <option key={s.id} value={s.id}>{s.nom} {s.prenom}</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Directeur mémoire</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.directeur_memoire_id} onChange={(e) => form.setData('directeur_memoire_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {teachers.map((t) => (
                                <option key={t.id} value={t.id}>{t.nom} {t.prenom}</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Évaluateur</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.evaluateur_id} onChange={(e) => form.setData('evaluateur_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {teachers.map((t) => (
                                <option key={t.id} value={t.id}>{t.nom} {t.prenom}</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Président jury</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.president_jury_id} onChange={(e) => form.setData('president_jury_id', e.target.value)}>
                            <option value="">Sélectionner</option>
                            {teachers.map((t) => (
                                <option key={t.id} value={t.id}>{t.nom} {t.prenom}</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Description</label>
                        <textarea className="mt-1 w-full rounded border-slate-300" value={form.data.description} onChange={(e) => form.setData('description', e.target.value)} />
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre à jour</button>
                        <Link href={route('soutenances.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
