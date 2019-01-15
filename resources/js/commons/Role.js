export default class Role {
    constructor(role) {
        this.name = role
    }

    isSuperadmin () {
        return this.name == 'superadmin'
    }

    isAdmin () {
        return this.name == 'admin' || this.name == 'superadmin'
    }

    isProvinceCoordinator () {
        return this.name == 'province-co'
    }

    isCityCoordinator () {
        return this.name == 'city-co'
    }

    isDistrictCoordinator () {
        return this.name == 'district-co'
    }

    isVillageCoordinator () {
        return this.name == 'village-co'
    }

    isVolunteer () {
        return this.name == 'volunteer'
    }
}
