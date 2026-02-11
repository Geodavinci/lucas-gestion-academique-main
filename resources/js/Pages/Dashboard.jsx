import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';

export default function Dashboard(props) {
    const { auth } = usePage().props;
    const {
        stats = {
            students: 0,
            teachers: 0,
            memoires: 0,
            soutenances: 0,
            recus: 0,
        },
        filieres = [],
        coursesList = [],
        teachersList = [],
        users = [],
        studentsList = [],
    } = props || {};

    const assignForm = useForm({
        course_id: '',
        teacher_id: '',
    });

    const roleForm = useForm({});
    const studentLinkForm = useForm({});
    const teacherLinkForm = useForm({});

    const isAdmin = auth?.user?.role === 'admin';

    return (
        <AuthenticatedLayout>
            <Head title="Dashboard" />

            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="mb-6">
                    <h1 className="text-2xl font-semibold">Dashboard</h1>
                    <p className="text-sm text-slate-600">Vue d'ensemble de l'application.</p>
                </div>

                <div className="grid grid-cols-1 gap-4 md:grid-cols-5">
                    {[
                        ['Étudiants', stats.students],
                        ['Enseignants', stats.teachers],
                        ['Mémoires', stats.memoires],
                        ['Soutenances', stats.soutenances],
                        ['Reçus', stats.recus],
                    ].map(([label, value]) => (
                        <div key={label} className="rounded-2xl border border-slate-200 bg-white p-4">
                            <p className="text-xs text-slate-500">{label}</p>
                            <p className="text-2xl font-semibold">{value}</p>
                        </div>
                    ))}
                </div>

                <div className="mt-6 rounded-2xl border border-slate-200 bg-white p-4">
                    <div className="mb-3 text-sm font-semibold text-slate-700">Accès rapide</div>
                    <div className="flex flex-wrap gap-2">
                        <Link href={route('memoires.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                            Mémoires
                        </Link>
                        <Link href={route('soutenances.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                            Soutenances
                        </Link>
                        <Link href={route('recu-paiements.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                            Reçus
                        </Link>
                        <Link href={route('teachers.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                            Enseignants
                        </Link>
                        {isAdmin && (
                            <Link href={route('admin.grades.index')} className="rounded border border-slate-300 px-3 py-2 text-sm">
                                Notes
                            </Link>
                        )}
                    </div>
                </div>

                <div className="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    {filieres.map((f) => (
                        <div key={f.id} className="rounded-xl border border-slate-200 bg-white p-4">
                            <div className="text-sm font-semibold text-slate-900">{f.nom}</div>
                            <div className="text-xs text-slate-500">{f.code}</div>
                            <div className="mt-2 text-2xl font-semibold text-slate-900">{f.enrollments_count}</div>
                            <div className="text-xs text-slate-500">étudiants</div>
                            <Link
                                href={route('students.index', { filiere: f.nom })}
                                className="mt-3 inline-flex text-xs font-medium text-slate-700 hover:text-slate-900"
                            >
                                Voir les étudiants →
                            </Link>
                        </div>
                    ))}
                </div>

                {isAdmin && (
                    <div className="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
                        <h2 className="text-lg font-semibold">Assigner un cours à un enseignant</h2>
                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                assignForm.post(route('admin.courses.assign'));
                            }}
                            className="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2"
                        >
                            <div>
                                <label className="block text-sm font-medium">Cours</label>
                                <select
                                    className="mt-1 w-full rounded border-slate-300"
                                    value={assignForm.data.course_id}
                                    onChange={(e) => assignForm.setData('course_id', e.target.value)}
                                >
                                    <option value="">Sélectionner un cours</option>
                                    {coursesList.map((c) => (
                                        <option key={c.id} value={c.id}>
                                            {c.nom} ({c.filiere?.code})
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium">Enseignant</label>
                                <select
                                    className="mt-1 w-full rounded border-slate-300"
                                    value={assignForm.data.teacher_id}
                                    onChange={(e) => assignForm.setData('teacher_id', e.target.value)}
                                >
                                    <option value="">Sélectionner un enseignant</option>
                                    {teachersList.map((t) => (
                                        <option key={t.id} value={t.id}>
                                            {t.nom} {t.prenom} ({t.specialite})
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="md:col-span-2">
                                <button className="rounded bg-slate-900 px-4 py-2 text-sm text-white">Assigner</button>
                            </div>
                        </form>
                    </div>
                )}

                {isAdmin && (
                    <div className="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
                        <h2 className="text-lg font-semibold">Gestion des rôles</h2>
                        <div className="mt-4 overflow-x-auto">
                            <table className="w-full text-sm">
                                <thead className="bg-slate-50 text-slate-600">
                                    <tr>
                                        <th className="text-left px-4 py-3">Utilisateur</th>
                                        <th className="text-left px-4 py-3">Rôle</th>
                                        <th className="text-left px-4 py-3">Étudiant lié</th>
                                        <th className="text-left px-4 py-3">Enseignant lié</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {users.map((u) => (
                                        <tr key={u.id} className="border-t">
                                            <td className="px-4 py-3">
                                                <div className="font-medium">{u.name}</div>
                                                <div className="text-xs text-slate-500">{u.email}</div>
                                            </td>
                                            <td className="px-4 py-3">
                                                <form
                                                    onSubmit={(e) => {
                                                        e.preventDefault();
                                                        roleForm.transform(() => ({ role: e.target.role.value }));
                                                        roleForm.patch(route('admin.users.role', u.id));
                                                    }}
                                                    className="flex items-center gap-2"
                                                >
                                                    <select name="role" defaultValue={u.role} className="rounded border-slate-300 text-sm">
                                                        <option value="user">Utilisateur</option>
                                                        <option value="teacher">Enseignant</option>
                                                        <option value="admin">Administrateur</option>
                                                    </select>
                                                    <button className="rounded bg-slate-900 px-3 py-1.5 text-xs text-white">Mettre à jour</button>
                                                </form>
                                            </td>
                                            <td className="px-4 py-3">
                                                <form
                                                    onSubmit={(e) => {
                                                        e.preventDefault();
                                                        studentLinkForm.transform(() => ({ student_id: e.target.student_id.value }));
                                                        studentLinkForm.patch(route('admin.users.student', u.id));
                                                    }}
                                                    className="flex items-center gap-2"
                                                >
                                                    <select name="student_id" defaultValue={u.student?.id || ''} className="rounded border-slate-300 text-sm">
                                                        <option value="">Lier un étudiant</option>
                                                        {studentsList.map((s) => (
                                                            <option key={s.id} value={s.id}>
                                                                {s.nom} {s.prenom}
                                                            </option>
                                                        ))}
                                                    </select>
                                                    <button className="rounded border border-slate-300 px-3 py-1.5 text-xs">Lier</button>
                                                </form>
                                            </td>
                                            <td className="px-4 py-3">
                                                <form
                                                    onSubmit={(e) => {
                                                        e.preventDefault();
                                                        teacherLinkForm.transform(() => ({ teacher_id: e.target.teacher_id.value }));
                                                        teacherLinkForm.patch(route('admin.users.teacher', u.id));
                                                    }}
                                                    className="flex items-center gap-2"
                                                >
                                                    <select name="teacher_id" defaultValue={u.teacher?.id || ''} className="rounded border-slate-300 text-sm">
                                                        <option value="">Lier un enseignant</option>
                                                        {teachersList.map((t) => (
                                                            <option key={t.id} value={t.id}>
                                                                {t.nom} {t.prenom}
                                                            </option>
                                                        ))}
                                                    </select>
                                                    <button className="rounded border border-slate-300 px-3 py-1.5 text-xs">Lier</button>
                                                </form>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
