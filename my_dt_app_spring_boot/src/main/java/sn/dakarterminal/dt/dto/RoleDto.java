package sn.dakarterminal.dt.dto;

import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;
import sn.dakarterminal.dt.enums.RoleName;

@Data
@Builder
@NoArgsConstructor
@AllArgsConstructor
public class RoleDto {
    private Long id;
    private RoleName name;
}
