import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Grades({ grades = [], filieres = [], filters = {} }) {
    const filiereId = filters.filiere_id || '';

    return (
        <AuthenticatedLayout>
            <Head title="Notes par filière" />

            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Notes par filière</h1>
                        <p className="text-sm text-slate-600">
                            Voir les notes des étudiants avec l’enseignant et le cours.
                        </p>
                    </div>
                    <div className="flex gap-2">
                        <Link href={route('dashboard')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                            Retour Dashboard
                        </Link>
                    </div>
                </div>

                <div className="bg-white rounded-xl border border-slate-200 p-4 mb-6">
                    <div className="flex flex-col gap-2 sm:flex-row sm:items-center">
                        <label className="text-sm font-medium">Filtrer par filière</label>
                        <select
                            className="rounded border-slate-300 text-sm"
                            value={filiereId}
                            onChange={(e) => {
                                const value = e.target.value;
                                const params = value ? { filiere_id: value } : {};
                                window.location.href = route('admin.grades.index', params);
                            }}
                        >
                            <option value="">Toutes les filières</option>
                            {filieres.map((f) => (
                                <option key={f.id} value={f.id}>
                                    {f.nom} ({f.code})
                                </option>
                            ))}
                        </select>
                    </div>
                </div>

                <div className="bg-white rounded-xl border border-slate-200 overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Étudiant</th>
                                <th className="text-left px-4 py-3">Filière</th>
                                <th className="text-left px-4 py-3">Cours</th>
                                <th className="text-left px-4 py-3">Enseignant</th>
                                <th className="text-left px-4 py-3">Session</th>
                                <th className="text-right px-4 py-3">Note</th>
                                <th className="text-right px-4 py-3">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            {grades.map((g) => (
                                <tr key={g.id} className="border-t">
                                    <td className="px-4 py-3">
                                        {g.student ? `${g.student.nom} ${g.student.prenom}` : '-'}
                                    </td>
                                    <td className="px-4 py-3">
                                        {g.course?.filiere ? g.course.filiere.nom : '-'}
                                    </td>
                                    <td className="px-4 py-3">{g.course?.nom || '-'}</td>
                                    <td className="px-4 py-3">
                                        {g.teacher ? `${g.teacher.nom} ${g.teacher.prenom}` : '-'}
                                    </td>
                                    <td className="px-4 py-3">{g.session || '-'}</td>
                                    <td className="px-4 py-3 text-right font-semibold">{g.note ?? '-'}</td>
                                    <td className="px-4 py-3 text-right">{g.date_saisie || '-'}</td>
                                </tr>
                            ))}
                            {grades.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="7">
                                        Aucune note trouvée.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
