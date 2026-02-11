import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Edit({ course, filieres, teachers }) {
    const form = useForm({
        filiere_id: course.filiere_id,
        nom: course.nom,
        code: course.code,
        coefficient: course.coefficient,
        semestre: course.semestre || '',
        teacher_ids: course.teachers?.map((t) => String(t.id)) || [],
    });

    return (
        <AuthenticatedLayout>
            <Head title="Modifier cours" />
            <div className="mx-auto max-w-3xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">Modifier cours</h1>
                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.put(route('courses.update', course.id));
                    }}
                    className="bg-white p-6 rounded border border-slate-200 space-y-4"
                >
                    <div>
                        <label className="block text-sm font-medium">Filière</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.filiere_id} onChange={(e) => form.setData('filiere_id', e.target.value)}>
                            {filieres.map((f) => (
                                <option key={f.id} value={f.id}>{f.nom} ({f.code})</option>
                            ))}
                        </select>
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Nom</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.nom} onChange={(e) => form.setData('nom', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Code</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.code} onChange={(e) => form.setData('code', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Coefficient</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.coefficient} onChange={(e) => form.setData('coefficient', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Semestre</label>
                        <input className="mt-1 w-full rounded border-slate-300" value={form.data.semestre} onChange={(e) => form.setData('semestre', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Enseignants</label>
                        <select
                            multiple
                            className="mt-1 w-full rounded border-slate-300"
                            value={form.data.teacher_ids}
                            onChange={(e) => form.setData('teacher_ids', Array.from(e.target.selectedOptions).map(o => o.value))}
                        >
                            {teachers.map((t) => (
                                <option key={t.id} value={t.id}>{t.nom} {t.prenom}</option>
                            ))}
                        </select>
                        <p className="text-xs text-slate-500 mt-1">Ctrl/Cmd + clic pour sélectionner plusieurs.</p>
                    </div>
                    <div className="pt-2">
                        <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Mettre à jour</button>
                        <Link href={route('courses.index')} className="ml-3 text-sm text-slate-600">Annuler</Link>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
